<?php

class AuthController {
  private $authModel;

  public function __construct() {
    $this->authModel = new Authentication();
  }

  /**
   * Handles the login process.
   * Redirects to the home page if the user is already logged in.
   *
   * @return void
   */
  public function login(): void {

    // display success message from people who come form registration form
    if(isset($_GET['reg']) && $_GET['reg'] === 'success') {
      $params['message'] = 'Usuario creado correctamente. Accede a tu cuenta y empieza a crear tu equipo Pokemon.';
    }

    if($this->authModel->isLoggedIn()) {
      header('Location: index.php?ctl=home');
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginBtn'])) {
      $params = array(
        'email' => '',
        'password' => '',
        'message'  => ''
      );
      
      $email = recoge('email');
      $password = recoge('password');

      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

        try {

          if ($this->authModel->login($email, $password)) {
            header('Location: index.php?ctl=poke_team');
            exit;
          }

        } catch (UserNotFoundException | IncorrectPasswordException $e) {
          $params['message'] = $e->getMessage();

        } catch (Exception $e) {
          error_log("Unexpected login error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
          header('Location: index.php?ctl=error');
          exit;
        }

      } else {
        $params['message'] = 'Formato de correo electrónico invalido.';
      }

      $params['email'] = $email;

    }

    require ROOT_PATH . '/web/templates/login.php';
  }

  /**
   * Handles the logout process.
   * Redirects to the login page if the logout is successful.
   *
   * @return void
   */
  public function logout(): void {
    try {

      if( $this->authModel->logout() ) {
        header('Location: index.php?ctl=login');
        exit;

      } else {
        header('Location: index.php?ctl=error');
        exit;

      }

    } catch (Exception $e) {
      error_log("Unexpected logout error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
      header('Location: index.php?ctl=error');
      exit;
    }
  }

  /**
   * Checks if a user is logged in.
   *
   * @return bool Returns true if a user is logged in, false otherwise.
   */
  public function isLoggedIn(): bool {
    return $this->authModel->isLoggedIn();
  }

  /**
   * Checks if the current logged-in user has the required role.
   *
   * @param string $role The role to check.
   * @return bool Returns true if the user has the required role, false otherwise.
   */
  public function currentUserCan(string $role): bool {
    return $this->authModel->hasPermission($role);
  }
  
}
