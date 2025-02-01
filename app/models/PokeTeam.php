<?php
/**
 * Poke team model
 * Controls everything related to a users pokemon team
 */
class PokeTeam extends DatabaseConnection {
  private $user_id;
  public function __construct( int $user_id ) {
    parent::__construct();
    $this->user_id = $user_id;
  }

  /**
   * Lists all Pokemon in the user's team.
   *
   * @return array|false Returns an array of Pokemon in the user's team, or false if the query fails.
   */
  public function listTeam(): array|false {
    $query  = "SELECT team.id, team.poke_id, pokemon.name, pokemon.gif FROM pokedex.poke_teams as team
      JOIN pokedex.pokemon as pokemon ON
      team.poke_id = pokemon.id WHERE team.user_id = :user_id";
    $statement = $this->connection->prepare($query);
    $statement->execute(['user_id' => $this->user_id]);

    return $statement->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * Adds a Pokemon to the user's team.
   *
   * @param int $poke_id The ID of the Pokemon to add.
   * 
   * @return bool Returns true if the Pokemon is added successfully
   */
  public function addPkmToTeam(int $poke_id): bool {
    try {
      $query  = "INSERT INTO pokedex.poke_teams (user_id, poke_id) VALUES (:user_id, :poke_id)";
      $statement = $this->connection->prepare($query);
      $statement->execute(['user_id' => $this->user_id, 'poke_id' => $poke_id]);

      return true;
    } catch (PDOException $e) {
      if ($e->getCode() == 23000) { // SQL integrity constraint violation
          throw new PokemonNotFoundException();
      }
      throw $e;
    }
  }

  /**
   * Removes a Pokemon from the user's team.
   *
   * @param int $id The ID of the team entry to remove.
   * 
   * @return bool Returns true if the Pokemon is removed successfully
   */
  public function removePkmFromTeam(int $id): bool {
    $query  = "DELETE FROM pokedex.poke_teams WHERE id = :id";
    $statement = $this->connection->prepare($query);
    $statement->execute(['id' => $id]);

    if ($statement->rowCount() === 0) {
      throw new PokemonNotFoundException();
    } else {
      return true;
    }
  }

  /**
   * Resets the user's team by removing all Pokemon.
   *
   * @return bool Returns true if the team is reset successfully
   */
  public function resetTeam(): bool {
    $query  = "DELETE FROM pokedex.poke_teams WHERE user_id = :user_id";
    $statement = $this->connection->prepare($query);
    $statement->execute(['user_id' => $this->user_id]);

    return true;
  }
}