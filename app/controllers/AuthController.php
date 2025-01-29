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
    $params = array(
      'username' => '',
      'password' => '',
      'message'  => ''
    );

    if($this->authModel->isLoggedIn()) {
      header('Location: index.php?ctl=home');
      exit;
    }

    if(isset($_GET['error'])) {
      $error = recoge('error');
      if($error === '401') {
        $params['message'] = 'No tienes permisos para acceder a esta página.';
      }
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['loginBtn'])) {
      $username = recoge('username');
      $password = recoge('password');

      if(cUser($username, "username", $params)) {

        try {

          if ($this->authModel->login($username, $password)) {
            header('Location: index.php?ctl=dashboard');
            exit;

          }

        } catch (UserNotFoundException | IncorrectPasswordException $e) {
          $params['message'] = $e->getMessage();

        } catch (Exception $e) {
          error_log("Unexpected login error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
          header('Location: index.php?ctl=error');
          exit;
        }

      } else {
        $params['message'] = 'Formato de nombre de usuario invalido.';
      }

      $params['username'] = $username;

    }

    require __DIR__ . '../../web/login.php';
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
      error_log("Unexpected logout error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
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
  public function currentUserIs(string $role): bool {
    return $this->authModel->hasPermission($role);
  }
  
}
