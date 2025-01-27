<?php

/**
 * Authentication model
 * 
 */
class Authentication extends DatabaseConnection {

  /**
   * Logs in a user by verifying their username and password.
   *
   * @param string $username
   * @param string $pass
   * 
   * @return bool  true if the login is successful
   */
  public function login(string $username, string $pass): bool {
    try {
      $query  = "SELECT * FROM pokedex.users WHERE username = :username";
      $statement = $this->connection->prepare($query);
      $statement->execute(['username' => $username]);

      $user = $statement->fetch(PDO::FETCH_OBJ);

      if ($user && password_verify($pass, $user->password)) {
        $_SESSION['user'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        return true;
      }

      return false;

    } catch (Exception $e) {
      error_log("Login failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }

  /**
   * Logs out the user by destroying the session.
   *
   * @return bool
   */  
  public function logout(): bool {
    session_destroy();
    return true;
  }

  /**
   * Checks if a user is logged in.
   *
   * @return bool
   */
  public function isLoggedIn():bool {
    return isset($_SESSION['user']);
  }

  /**
   * Checks if a user has the required role.
   *
   * @param string $requiredRole
   * 
   * @return bool
   */
  public function hasPermission(string $requiredRole): bool {
    return isset($_SESSION['role']) && $_SESSION['role'] === $requiredRole;
  }
    
}
?>