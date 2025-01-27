<?php
/**
 * Pokemon model
 * Controls everything related to the pokemon information
 */
class Pokemon extends DatabaseConnection {
  

  /**
   * Lists all Pokémon.
   *
   * @return array
   */
  public function listAll(): array {
    try {
      $query  = "SELECT * FROM pokedex.pokemon ORDER BY id ASC";
      $statement = $this->connection->prepare($query);
      $statement->execute();

      return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      error_log("List all pokemon failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return [];
    }
    
  }

  /**
   * Finds a Pokémon by name.
   *
   * @param string $name The name of the Pokémon.
   * 
   * @return object|false Returns an object with the Pokémon data if found, false otherwise.
   */
  public function find(string $name): object|false {
    try {
      $query  = "SELECT * FROM pokedex.pokemon WHERE LOWER(name) = LOWER(:name)";
      $statement = $this->connection->prepare($query);
      $statement->execute(['name' => $name]);

      return $statement->fetch(PDO::FETCH_OBJ);

    } catch (Exception $e) {
      error_log("Find pokemon failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }

  /**
   * Adds a new Pokémon.
   *
   * @param int $poke_id The ID of the Pokémon.
   * @param string $name The name of the Pokémon.
   * @param string $type_1 The primary type of the Pokémon.
   * @param string|null $type_2 The secondary type of the Pokémon (optional).
   * @param string $description The description of the Pokémon.
   * @param string $artwork_path The path to the artwork image of the Pokémon.
   * @param string $sprite_path The path to the sprite image of the Pokémon.
   * @param string|null $gif_path The path to the gif image of the Pokémon (optional).
   * 
   * @return bool Returns true if the Pokémon is added successfully
   */
  public function add(int $poke_id, string $name, string $type_1, string $type_2 = null, string $description, string $artwork_path, string $sprite_path, string $gif_path = null): bool {
    try {
      $query  = "INSERT INTO pokedex.pokemon (poke_id, name, type_1, type_2, description, artwork, sprite, gif) 
                  VALUES (:poke_id, :name, :type_1, :type_2, :description, :artwork_path, :sprite_path, :gif_path)";
      $statement = $this->connection->prepare($query);
      $statement->execute(['poke_id' => $poke_id, 'name' => $name, 'type_1' => $type_1, 'type_2' => $type_2, 'description' => $description, 'artwork_path' => $artwork_path, 'sprite_path' => $sprite_path, 'gif_path' => $gif_path]);

      return true;

    } catch (Exception $e) {
      error_log("Add pokemon failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }
  
  /**
   * Edits a Pokémon's information.
   *
   * @param int $poke_id The ID of the Pokémon.
   * @param array $new_data An associative array of the new Pokémon data.
   * It can include the following keys: name, type_1, type_2, description, artwork, sprite, gif.
   * 
   * @return bool Returns true if the Pokémon is edited successfully, false otherwise.
   */
  public function edit(int $poke_id, array $new_data): bool {
    try {
      $query = "UPDATE pokedex.pokemon SET ";

      // Dynamically build the query with the new data array
      $updates = [];
      $params  = [];
      foreach ($new_data as $column => $value) {
        $updates[]       = "$column = :$column";
        $params[$column] = $value;
      }

      // Join the updates with commas and append to the query
      $query .= implode(", ", $updates);
      $query .= " WHERE poke_id = :poke_id";

      // Add the `poke_id` to the parameter array
      $params['poke_id'] = $poke_id;

      // Prepare and execute the query
      $statement = $this->connection->prepare($query);
      $statement->execute($params);

      return true;
    } catch (Exception $e) {
      error_log("Edit pokemon failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
}


  /**
   * Deletes a Pokémon
   *
   * @param int $poke_id The id of the Pokémon.
   * @return bool Returns true if the Pokémon is deleted successfully
   */
  public function delete(int $poke_id): bool {
    try {
      $query  = "DELETE FROM pokedex.pokemon WHERE poke_id = :poke_id";
      $statement = $this->connection->prepare($query);
      $statement->execute(['poke_id' => $poke_id]);

      return true;

    } catch (Exception $e) {
      error_log("Delete pokemon failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }

}