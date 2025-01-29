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
    $query  = "SELECT * FROM pokedex.pokemon ORDER BY id ASC";
    $statement = $this->connection->prepare($query);
    $statement->execute();

    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Finds a Pokémon by name.
   *
   * @param string $name The name of the Pokémon.
   * 
   * @return array|false Returns an object with the Pokémon data if found, false otherwise.
   */
  public function find(string $name): array|false {
    $query  = "SELECT * FROM pokedex.pokemon WHERE LOWER(name) = LOWER(:name)";
    $statement = $this->connection->prepare($query);
    $statement->execute(['name' => $name]);

    return $statement->fetch(PDO::FETCH_ASSOC);
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
    $query  = "INSERT INTO pokedex.pokemon (poke_id, name, type_1, type_2, description, artwork, sprite, gif) 
                VALUES (:poke_id, :name, :type_1, :type_2, :description, :artwork_path, :sprite_path, :gif_path)";
    $statement = $this->connection->prepare($query);
    $statement->execute(['poke_id' => $poke_id, 'name' => $name, 'type_1' => $type_1, 'type_2' => $type_2, 'description' => $description, 'artwork_path' => $artwork_path, 'sprite_path' => $sprite_path, 'gif_path' => $gif_path]);

    return true;
  }

  /**
   * Deletes a Pokémon
   *
   * @param int $poke_id The id of the Pokémon.
   * @return bool Returns true if the Pokémon is deleted successfully
   */
  public function delete(int $poke_id): bool {
    $query  = "DELETE FROM pokedex.pokemon WHERE poke_id = :poke_id";
    $statement = $this->connection->prepare($query);
    $statement->execute(['poke_id' => $poke_id]);

    if ($statement->rowCount() === 0) {
      throw new PokemonNotFoundException();
    } else {
      return true;
    }
  }

  /**
   * Get all possible Pokémon types.
   */
  public function getPokeTypes(): array {
    $query  = "SELECT name FROM pokedex.pokemon_types ORDER BY id ASC";
    $statement = $this->connection->prepare($query);
    $statement->execute();

    // Fetch only the first column
    return $statement->fetchAll(PDO::FETCH_COLUMN, 0); 
  }

}