<?php

class PokeTeamController {
  private $pokeTeamModel;

  public function __construct() {
    $auth = new Authentication();
    $this->pokeTeamModel = new PokeTeam($auth->getCurrentUserId());
  }

  /**
   * Lists all Pokemon in the user's team.
   * Checks for logged in user
   *
   * @return void
   */
  public function listPokeTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    // display messages for adding, removind and reseting
    if(isset($_GET['msg'])) {
      $msg = recoge('msg');
      
      switch($msg) {
        case 'add_id':
          $params['message'] = 'No se puede añadir ese pokemon.';
          break;
        case 'add_404':
          $params['message'] = 'No hemos encontrado ese pokemon para añadirlo.';
          break;
        case 'add_500':
          $params['message'] = 'Pokemon añadido a tu equipo.';
          break;
        case 'rmv_id':
          $params['message'] = 'No se puede remover ese pokemon.';
          break;
        case 'rmv_404':
          $params['message'] = 'No hemos encontrado ese pokemon para removerlo.';
          break;
        case 'rmv_500':
          $params['message'] = 'Pokemon removido del equipo.';
          break;
        case 'rst_500':
          $params['message'] = 'Equipo redefinido con éxito.';
          break;
      }
    
    }

    try {
      $pokeTeam = $this->pokeTeamModel->listTeam();

      // Also call the for a the list of all pokemon to make the select in the add pokemon 
      $pkmModel = new Pokemon();
      $pokemons = $pkmModel->listAll();

      $params['pokeTeam'] = $pokeTeam;
      $params['pokemons'] = $pokemons;
      
    } catch (Exception $e) {
      error_log("PokeTeam listing error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
      header('Location: index.php?ctl=error');
      exit;
    }

    include ROOT_PATH . '/web/templates/pokeTeam.php';
  }

  /**
   * Adds a Pokemon to the user's team.
   * Checks for logged in user
   *
   * @return void
   */
  public function addPkmToTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addToTeam'])) {
      $params = [
        'errors' => [],
        'message' => ''
      ];
      
      $errors = [];

      $poke_id = recoge('poke_id');
      cNum($poke_id, 'poke_id', $errors);

      if( !empty($errors) ) {
        $params = [
          'errors' => $errors,
        ];
        header('Location: index.php?ctl=poke_team&msg=add_id');
        exit;
      }

      try {

        $this->pokeTeamModel->addPkmToTeam($poke_id);

      } catch( PokemonNotFoundException $e ) {
        $params = [
          'message' => $e->getMessage(),
        ];
        header('Location: index.php?ctl=poke_team&msg=add_404');
        exit;
        
      } catch (Exception $e) {
        error_log("PokeTeam add error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    header('Location: index.php?ctl=poke_team&msg=add_500');
  }

  /**
   * Removes a Pokemon from the user's team.
   * Checks for logged in user
   *
   * @return void
   */
  public function removePkmFromTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteFromTeam'])) {
      // first validate inputs
      $poke_id = recoge('poke_id');

      $errors = [];
      cNum($poke_id, 'poke_id', $errors, 1);

      if(!empty($errors)) {
        $params = [
          'errors' => $errors,
        ];
        header('Location: index.php?ctl=poke_team&msg=rmv_id');
        exit;
      }

      try {
        // delete the pokemon
        $this->pokeTeamModel->removePkmFromTeam($poke_id);

      } catch (PokemonNotFoundException $e) {
        header('Location: index.php?ctl=poke_team&msg=rmv_404');

      } catch (Exception $e) {
        error_log("Remove from team error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    header('Location: index.php?ctl=poke_team&msg=rmv_500');
  }

  /**
   * Resets the user's team by removing all Pokemon.
   * Checks for logged in user
   *
   * @return void
   */
  public function resetPokeTeam(): void {
    $auth = new AuthController();
    if(!$auth->isLoggedIn()) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['resetTeamBtn'])) {
      try {
        // delete the pokemon
        $this->pokeTeamModel->resetTeam();

      } catch (Exception $e) {
        error_log("Reset team error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    header('Location: index.php?ctl=poke_team&msg=rst_500');
  }
  
} 