<?php

class UserController {
  private $userModel;

  public function __construct() {
    $this->userModel = new User();
  }

  /**
   * Lists all users.
   * Checks for admin role.
   *
   * @return void
   */
  public function listAll(): void {
    $auth = new AuthController();
    if(!$auth->currentUserCan('admin')) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    // display messages for editing and removind users
    if(isset($_GET['msg'])) {
      $msg = recoge('msg');
      
      switch($msg) {
        case 'edit_role':
          $params['message'] = 'Hubieron problemas para editar el perfil del usuario. Vulve a intentar.';
          break;
        case 'edit_404':
          $params['message'] = 'No hemos encontrado ese usurario para editar su perfil.';
          break;
        case 'edit_500':
          $params['message'] = 'Usuario editado con éxito.';
          break;
        case 'rmv_id':
          $params['message'] = 'No se puede remover ese usuario.';
          break;
        case 'rmv_404':
          $params['message'] = 'No hemos encontrado ese usuario para removerlo.';
          break;
        case 'rmv_500':
          $params['message'] = 'Usuario removido.';
          break;

      }
    
    }

    try {
      // get all users
      $users = $this->userModel->listAll();

      $params['users'] = $users;

    } catch (Exception $e) {
      error_log("Users listing error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
      header('Location: index.php?ctl=error');
      exit;
    }

    // get the template
    include ROOT_PATH . '/web/templates/usersList.php';
  }

   /**
   * Registers a new user.
   *
   * @return void
   */
  public function registerUser(): void {
    $auth = new Authentication();
    if($auth->isLoggedIn()) {
      header('Location: index.php?ctl=home');
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerBtn'])) {
      $params = [
        'errors' => [],
        'message' => ''
      ];
      
      $errors = [];
      
      // first validate texts
      $name     = recoge('name');
      $email    = recoge('email');
      $password = recoge('password');
    
      // check for errors
      if(!isset($_POST['name'])) {
        $errors['name'] = 'El nombre es obligatorio';
      } else {
        cTexto($name, 'name', $errors);
      }

      if(!isset($_POST['email'])) {
        $errors['email'] = 'El email es obligatorio';
      } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'El email es no es valido';
      }
      
      if(!isset($_POST['password'])) {
        $errors['password'] = 'La contraseña es obligatoria';
      }

      if(!empty($errors)) {
        $params = [
          'errors' => $errors,
        ];
        include ROOT_PATH . '/web/templates/signup.php';
        exit;
      }

      // if there is no errors, validate the image
      if ( $_FILES['profile_pic']['size'] == 0) {
        // if there is no image, use the default
        $profile_pic = Config::$default_avatar;
      } else {
        $profile_pic = cFile('profile_pic', $errors, Config::$allowed_profile_extensions, Config::$images_trainers_path, Config::$max_file_size, false);
      }

      if(!empty($errors)) {
        $params = [
          'errors' => $errors,
        ];
        include ROOT_PATH . '/web/templates/signup.php';
        exit;
      }

      // if all is well, create the user
      try {
        $this->userModel->create($name, $email, password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]), 'trainer', $profile_pic);
        header('Location: index.php?ctl=login&reg=success');
      
      } catch (PDOException $e) { 

        if ($e->getCode() == 23000) { // Unique constraint error
          $errors['email'] = 'Este correo electrónico ya esta registrado.';
          $params['errors'] = $errors;
          include ROOT_PATH . '/web/templates/signup.php';
          
        } else {
          error_log("User creation error: " . $e->getMessage() . " " . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
          header('Location: index.php?ctl=error');
        }
      } catch (Exception $e) {
        error_log("User creation error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    include ROOT_PATH . '/web/templates/signup.php';
  }

  /**
   * Gets the current logged-in user's data.
   * Checks for logged in user
   *
   * @return array
   */
  public function getUserData(): array {
    $auth = new Authentication();
    if (!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    $params = [
      'errors' => [],
      'user'   => []
    ];

    try {
      $user = $this->userModel->get($auth->getCurrentUserId());
      
      if( !$user ) {
        header('Location: index.php?ctl=home&error=401');
        exit;
      }

      return $user;

    } catch (Exception $e) {
      error_log("User data error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
      header('Location: index.php?ctl=error');
      exit;
    }

  }

  /**
   * Deletes a user by ID.
   * Checks for admin role.
   *
   * @return void
   */
  public function deleteUser(): void {
    $auth = new AuthController();
    if(!$auth->currentUserCan('admin')) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteUserBtn'])) {
      // first validate inputs
      $user_id = recoge('user_id');

      $errors = [];
      cNum($user_id, 'user_id', $errors, 1);

      if(!empty($errors)) {
        $params = [
          'errors' => $errors,
        ];
        header('Location: index.php?ctl=user_list&msg=rmv_id');
        exit;
      }

      try {
        $user_data = $this->userModel->get($user_id);
        $profile_picture = $user_data['profile_picture'];

        // delete the user
        $result = $this->userModel->delete($user_id);

        // should delete the profile_picture from the server but I don't want to loose them in testing
        /*
        if(file_exists($profile_picture) && $profile_picture !== Config::$default_avatar) {
          unlink($profile_picture);
        }
        */

      } catch (UserNotFoundException $e) {
        header('Location: index.php?ctl=user_list&msg=rmv_404');

      } catch (Exception $e) {
        error_log("User deleting error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    header('Location: index.php?ctl=user_list&msg=rmv_500');
  }

  /**
   * Updates a user role
   */
  public function updateUserRole(): void {
    $auth = new AuthController();
    if(!$auth->currentUserCan('admin')) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateRoleBtn'])) {

      $user_id  = recoge('user_id');
      $new_role = recoge('new_role');

      $errors = [];
      cNum($user_id, 'user_id', $errors, 1);
      cTexto($new_role, 'new_role', $errors);

      // If there are validation errors, show them
      if(!empty($errors)) {
        header('Location: index.php?ctl=user_list&msg=edit_role');
        exit;
      }

      try {
        $this->userModel->updateRole($user_id, $new_role);

      } catch (UserNotFoundException $e) {
        header('Location: index.php?ctl=user_list&msg=edit_404');
      } catch (Exception $e) {
          error_log("User role update error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
          header('Location: index.php?ctl=error');
          exit;
      }
    }

    header('Location: index.php?ctl=user_list&msg=edit_500');

  }

} 