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
   * @param string $username
   * @param string $password
   * @param string $role
   * @param string $picture
   * 
   * @return bool true if the user was created successfully
   */
  public function create(string $name, string $email, string $password, string $role, string $picture): bool {
    $query  = "INSERT INTO pokedex.users (name, email, password, role, profile_picture) 
                VALUES (:name, :email, :password, :role, :profile_picture)";
    $statement = $this->connection->prepare($query);
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password, 'role' => $role, 'profile_picture' => $picture]);

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
    $query  = "SELECT id, name, email, role, profile_picture, created_at FROM pokedex.users WHERE id = :id";
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

  /**
   * Changes a user role
   * 
   * @param string $user_id
   * @param string $new_role
   * 
   * @return bool Returns true if the role is updated successfully
   */
  public function updateRole(string $user_id, string $new_role): bool {
    $query = "UPDATE pokedex.users SET role = :role WHERE id = :id";
    $statement = $this->connection->prepare($query);
    $statement->execute(['id' => $user_id, 'role' => $new_role]);

    if ($statement->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

}
?>