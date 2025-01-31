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
      header('Location: index.php?ctl=login&error=401');
      exit;
    }

    try {
      // get all users
      $users = $this->userModel->listAll();

      $params = [
        'users' => $users
      ];

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
    echo 'Registering user...<br/><br/>';
    $auth = new Authentication();
    if($auth->isLoggedIn()) {
      header('Location: index.php?ctl=home');
      exit;
    }

    $params = [
      'errors' => [],
      'message' => ''
    ];

    var_dump($_POST);

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registerBtn'])) {
      echo 'En el if...<br/><br/>';

      $errors = [];
      
      // first validate texts
      $name     = recoge('name');
      $password = recoge('password');

      if(!isset($_POST['name'])) {
        $errors['name'] = 'El nombre es obligatorio';
      } else {
        cTexto($name, 'name', $errors);
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

      // now validate the image
      $profile_pic = cFile('profile_pic', $errors, Config::$allowed_profile_extensions, Config::$images_trainers_path, Config::$max_file_size, false);
      
      if(!$profile_pic) {
        $profile_pic = null;
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
        echo 'En el try...<br/><br/>';

        $this->userModel->create($name, password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]), 'trainer', $profile_pic);
        $params['message'] = 'Usuario creado correctamente. ¡Bienvenido a tu Pokedex!';
        header('Location: index.php?ctl=poke_team');
      
      } catch (Exception $e) {
        error_log("User creation error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        //header('Location: index.php?ctl=error');
        var_dump($e->getMessage());
        exit;
      }
    }

    include ROOT_PATH . '/web/templates/signup.php';
  }

  /**
   * Gets the current logged-in user's data.
   * Checks for logged in user
   *
   * @return void
   */
  public function getUserData(): void {
    $auth = new Authentication();
    if (!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=login&error=401');
      exit;
    }

    $params = [
      'errors' => [],
      'user'   => []
    ];

    try {
      $user = $this->userModel->get($auth->getCurrentUserId());
      if( !$user ) {
        header('Location: index.php?ctl=login&error=401');
        exit;
      }

      $params['user'] = $user;

    } catch (Exception $e) {
      error_log("User data error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
      header('Location: index.php?ctl=error');
      exit;
    }

    include ROOT_PATH . '/web/templates/userData.php';
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
      header('Location: index.php?ctl=login&error=401');
      exit;
    }

    $params = [
      'errors' => [],
      'message' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
      // first validate inputs
      $user_id = recoge('user_id');

      $errors = [];
      cNum($user_id, 'user_id', $errors, 1);

      if(!empty($errors)) {
        $params = [
          'errors' => $errors,
        ];
        include ROOT_PATH . '/web/templates/usersList.php';
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

        $params = [
          'message' => 'El usuario ' . $user_id . ' se ha borrado exitosamente.'
        ];

      } catch (UserNotFoundException $e) {
        $params = [
          'message' => 'El usuario con el ID ' . $user_id . ' no existe en la base de datos.'
        ];
      } catch (Exception $e) {
        error_log("User deleting error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    include ROOT_PATH . '/web/templates/pokemonList.php';
  }
} 