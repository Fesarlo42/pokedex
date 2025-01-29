<?php
/**
 * User model
 * Controls everything related to the users information
 */
class User extends DatabaseConnection {

  /**
   * Lists all users.
   *
   * @return array An array of all users.
   */
  public function listAll(): array {
    $query  = "SELECT * FROM pokedex.users ORDER BY id ASC";
    $statement = $this->connection->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Creates a new user.
   *
   * @param string $name
   * @param string $password
   * @param string $role
   * @param string $picture optional default to the defaut avatar
   * 
   * @return bool true if the user was created successfully
   */
  public function create(string $name, string $password, string $role, string $picture = Config::$default_avatar): bool {
    $query  = "INSERT INTO pokedex.users (name, password, role, picture) 
                VALUES (:name, :password, :role, :picture)";
    $statement = $this->connection->prepare($query);
    $statement->execute(['name' => $name, 'password' => $password, 'role' => $role, 'picture' => $picture]);

    return true;
  }
  
  /**
   * Gets a user by id.
   *
   * @param string $id
   * 
   * @return array|false An array with the user information or false if the user is not found
   */
  public function get(string $id): array|false {
    $query  = "SELECT id, name, role, profile_picture, created_at FROM pokedex.users WHERE id = :id";
    $statement = $this->connection->prepare($query);
    $statement->execute(['id' => $id]);

    return $statement->fetch(PDO::FETCH_ASSOC);
  }

  /**
   * Deletes user.
   *
   * @param string $user_id The ID of the user.
   * 
   * @return bool Returns true if the user is deleted successfully
   */
  public function delete(string $user_id): bool {
    $query  = "DELETE FROM pokedex.users WHERE id = :id";
    $statement = $this->connection->prepare($query);
    $statement->execute(['id' => $user_id]);

    if ($statement->rowCount() === 0) {
      throw new UserNotFoundException();
    } else {
      return true;
    }
  }
}
?>