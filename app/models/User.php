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
      try {
        $query  = "SELECT * FROM pokedex.users ORDER BY id ASC";
        $statement = $this->connection->prepare($query);
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);

      } catch (Exception $e) {
        error_log("List all users failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
        return [];
      }
    }

    /**
     * Creates a new user.
     *
     * @param string $name
     * @param string $user_name
     * @param string $email
     * @param string $password
     * @param string $role
     * @param string $picture optional default to the defaut avatar
     * 
     * @return bool true if the user was created successfully
     */
    public function create(string $name,string $user_name, string $email, string $password, string $role, string $picture = Config::$default_avatar): bool {
      try {
        $query  = "INSERT INTO pokedex.users (name, user_name, email, password, role, picture) 
                    VALUES (:name, :user_name, :email, :password, :role, :picture)";
        $statement = $this->connection->prepare($query);
        $statement->execute(['name' => $name, 'user_name' => $user_name, 'email' => $email, 'password' => $password, 'role' => $role, 'picture' => $picture]);

        return true;

      } catch (Exception $e) {
        error_log("Add user failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
        return false;
      }
    }
   
    /**
     * Gets a user by username.
     *
     * @param string $username
     * 
     * @return array|false An array with the user information or false if the user is not found
     */
    public function get(string $username): array|false {
      try {
        $query  = "SELECT * FROM pokedex.users WHERE user_name = :username";
        $statement = $this->connection->prepare($query);
        $statement->execute(['username' => $username]);

        return $statement->fetch(PDO::FETCH_ASSOC);

      } catch (Exception $e) {
        error_log("Get user failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
        return false;
      }
    }

    /**
     * Edits a user's information.
     *
     * @param string $user_id The ID of the user.
     * @param array $new_data An associative array of the new user data.
     * It can include the following keys: name, user_name, email, password, role, picture.
     * 
     * @return bool Returns true if the user is edited successfully
     */
    public function edit(string $user_id, array $new_data): bool {
      try {
        $query = "UPDATE pokedex.users SET ";

        // Dynamically build the query with the new data array
        $updates = [];
        $params  = [];
        foreach ($new_data as $column => $value) {
          $updates[]       = "$column = :$column";
          $params[$column] = $value;
        }

        $query .= implode(", ", $updates);
        $query .= " WHERE id = :id";
        $params['id'] = $user_id;

        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return true;

      } catch (Exception $e) {
        error_log("Edit user failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
        return false;
      }
    }

    /**
     * Deletes user.
     *
     * @param string $user_id The ID of the user.
     * 
     * @return bool Returns true if the user is deleted successfully
     */
    public function delete(string $user_id): bool {
      try {
        $query  = "DELETE FROM pokedex.users WHERE id = :id";
        $statement = $this->connection->prepare($query);
        $statement->execute(['id' => $user_id]);

        return true;

      } catch (Exception $e) {
        error_log("Delete user failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
        return false;
      }
    }
}
?>