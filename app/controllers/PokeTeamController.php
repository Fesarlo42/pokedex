<?php

class PokeTeamController {
  private $pokeTeamModel;

  public function __construct() {
    $auth = new Authentication();
    $this->pokeTeamModel = new PokeTeam($auth->getCurrentUserId());
  }

  /**
   * Lists all Pokémon in the user's team.
   * Checks for logged in user
   *
   * @return void
   */
  public function listPokeTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=login&error=401');
      exit;
    }

    try {
      $pokeTeam = $this->pokeTeamModel->listTeam();
      $params = [
        'pokeTeam' => $pokeTeam
      ];
    } catch (Exception $e) {
      error_log("PokeTeam listing error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
      header('Location: index.php?ctl=error');
      exit;
    }

    include ROOT_PATH . '/web/templates/pokeTeam.php';
  }

  /**
   * Adds a Pokémon to the user's team.
   * Checks for logged in user
   *
   * @return void
   */
  public function addPkmToTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=login&error=401');
      exit;
    }

    $params = [
      'errors' => [],
      'message' => ''
    ];

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_team'])) {
      $errores = [];

      $poke_id = recoge('poke_id');
      cNum($poke_id, 'poke_id', $errors);

      if( !empty($errors) ) {
        $params = [
          'errors' => $errors,
        ];
        include ROOT_PATH . '/web/templates/pokemon.php';
        exit;
      }

      try {

        $this->pokeTeamModel->addPkmToTeam($poke_id);
        $params['message'] = '¡Pokemon añadido al equipo!';

      } catch(PokemonNotFoundException $e) {
        $params = [
          'errors' => $e->getMessage(),
        ];
        include ROOT_PATH . '/web/templates/pokemon.php';
        exit;
        
      } catch (Exception $e) {
        error_log("PokeTeam add error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    include ROOT_PATH . '/web/templates/pokemon.php';
  }

  /**
   * Removes a Pokémon from the user's team.
   * Checks for logged in user
   *
   * @return void
   */
  public function removePkmFromTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=login&error=401');
      exit;
    }

    $params = [
      'errors' => [],
      'message' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_from_team'])) {
      // first validate inputs
      $poke_id = recoge('poke_id');

      $errors = [];
      cNum($poke_id, 'poke_id', $errors, 1);

      if(!empty($errors)) {
        $params = [
          'errors' => $errors,
        ];
        include ROOT_PATH . '/web/templates/pokeTeam.php';
        exit;
      }

      try {
        // delete the pokemon
        $result = $this->pokeTeamModel->removePkmFromTeam($poke_id);

        $params = [
          'message' => 'El Pokémon se ha borrado del equipo.'
        ];

      } catch (PokemonNotFoundException $e) {
        $params = [
          'message' => 'El Pokémon con el ID ' . $poke_id . ' no existe en la base de datos.'
        ];
      } catch (Exception $e) {
        error_log("Remove from team error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    include ROOT_PATH . '/web/templates/pokeTeam.php';
  }

  /**
   * Resets the user's team by removing all Pokémon.
   * Checks for logged in user
   *
   * @return void
   */
  public function resetPokeTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=login&error=401');
      exit;
    }

    $params = [
      'message' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset_team'])) {
      try {
        // delete the pokemon
        $result = $this->pokeTeamModel->resetTeam();

        $params = [
          'message' => 'El equipo se ha borrado con exito.'
        ];

      } catch (Exception $e) {
        error_log("Reset team error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    include ROOT_PATH . '/web/templates/pokeTeam.php';
  }
  
} 