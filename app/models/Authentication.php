<?php

/**
 * Authentication model
 * 
 */
class Authentication extends DatabaseConnection {

  /**
   * Logs in a user by verifying their username and password.
   *
   * @param string $email
   * @param string $pass
   * 
   * @return bool  true if the login is successful
   */
  public function login(string $email, string $pass): bool {
    $query  = "SELECT * FROM pokedex.users WHERE email = :email";
    $statement = $this->connection->prepare($query);
    $statement->execute(['email' => $email]);

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if(!$user) {
      throw new UserNotFoundException();
    }

    if (!password_verify($pass, $user['password'])) {
      throw new IncorrectPasswordException();
    }

    $_SESSION['user'] = $user['id'];
    $_SESSION['role'] = $user['role'];

    // add cookie to check how long the user's been logged in
    setcookie('login_time', time(), time() + 86400);
    
    return true;
  }

  /**
   * Logs out the user by destroying the session.
   *
   * @return bool
   */  
  public function logout(): bool {
    session_destroy();
    setcookie('login_time', '', time() - 3600);
    return true;
  }

  /**
   * Checks if a user is logged in.
   *
   * @return bool
   */
  public function isLoggedIn():bool {
    return isset($_SESSION['user']) && $_SESSION['user'] !== 'guest';
  }

  /**
   * Returns the current loged in user's id.
   *
   * @return bool
   */
  public function getCurrentUserId():string {
    return $_SESSION['user'];
  }

  /**
   * Checks if a user has the required role.
   *
   * @param string $requiredRole
   * 
   * @return bool
   */
  public function hasPermission(string $requiredRole): bool {
    switch ($requiredRole) {
      case 'admin':
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

      case 'trainer':
        return isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'trainer');
      
      case 'guest':
        return true;
        
      default: 
        return false;
    }

  }
    
}
?>