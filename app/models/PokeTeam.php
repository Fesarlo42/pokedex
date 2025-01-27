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
   * Adds a Pokémon to the user's team.
   *
   * @param int $poke_id The ID of the Pokémon to add.
   * 
   * @return bool Returns true if the Pokémon is added successfully
   */
  public function addPkmToTeam(int $poke_id): bool {
    try {
      $query  = "INSERT INTO pokedex.poke_teams (user_id, poke_id) VALUES (:user_id, :poke_id)";
      $statement = $this->connection->prepare($query);
      $statement->execute(['user_id' => $this->user_id, 'poke_id' => $poke_id]);

      return true;

    } catch (Exception $e) {
      error_log("Add pokemon to team failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }


  /**
   * Removes a Pokémon from the user's team.
   *
   * @param int $id The ID of the team entry to remove.
   * 
   * @return bool Returns true if the Pokémon is removed successfully
   */
  public function removePkmFromTeam(int $id): bool {
    try {
      $query  = "DELETE FROM pokedex.poke_teams WHERE id = :id";
      $statement = $this->connection->prepare($query);
      $statement->execute(['id' => $id]);

      return true;

    } catch (Exception $e) {
      error_log("Remove pokemon from team failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }

  /**
   * Lists all Pokémon in the user's team.
   *
   * @return array|false Returns an array of Pokémon in the user's team, or false if the query fails.
   */
  public function listTeam(): array|false {
    try {
      $query  = "SELECT * FROM pokedex.poke_teams WHERE user_id = :user_id";
      $statement = $this->connection->prepare($query);
      $statement->execute(['user_id' => $this->user_id]);

      return $statement->fetchAll(PDO::FETCH_ASSOC);

    } catch (Exception $e) {
      error_log("List team failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }

  /**
   * Resets the user's team by removing all Pokémon.
   *
   * @return bool Returns true if the team is reset successfully
   */
  public function resetTeam(): bool {
    try {
      $query  = "DELETE FROM pokedex.poke_teams WHERE user_id = :user_id";
      $statement = $this->connection->prepare($query);
      $statement->execute(['user_id' => $this->user_id]);

      return true;

    } catch (Exception $e) {
      error_log("Reset team failed: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/log/error_log.txt");
      return false;
    }
  }
}