<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define('ROOT_PATH', dirname(__DIR__));

// require libraries
require_once ROOT_PATH . '/app/libs/Config.php';
require_once ROOT_PATH . '/app/libs/bGeneral.php';
require_once ROOT_PATH . '/app/libs/CustomExceptions.php';

// require models
require_once ROOT_PATH . '/app/models/DatabaseConnection.php';
require_once ROOT_PATH . '/app/models/Pokemon.php';
require_once ROOT_PATH . '/app/models/Authentication.php';
require_once ROOT_PATH . '/app/models/User.php';
require_once ROOT_PATH . '/app/models/PokeTeam.php';

// require controllers
require_once ROOT_PATH . '/app/controllers/BaseController.php';
require_once ROOT_PATH . '/app/controllers/PokemonController.php';
require_once ROOT_PATH . '/app/controllers/AuthController.php';
require_once ROOT_PATH . '/app/controllers/UserController.php';
require_once ROOT_PATH . '/app/controllers/PokeTeamController.php';


// start session
session_start();

// check user login status
if( !isset($_SESSION['user']) ) {
  $_SESSION['role'] = 'guest';
}

// Routing
$routes = [
  'home'         => ['controller' => 'BaseController',     'action' => 'home',         'user_role' => 'guest'],
  'pokemon_list' => ['controller' => 'PokemonController',  'action' => 'listPokemons', 'user_role' => 'guest'],
  'pokemon'      => ['controller' => 'PokemonController',  'action' => 'getPokemon',   'user_role' => 'guest'],
  'login'        => ['controller' => 'AuthController',     'action' => 'login',        'user_role' => 'guest'],
  'signup'       => ['controller' => 'UserController',     'action' => 'registerUser', 'user_role' => 'guest'],
  'error'        => ['controller' => 'BaseController',     'action' => 'error',        'user_role' => 'guest'],
  
  'poke_team'        => ['controller' => 'PokeTeamController', 'action' => 'listPokeTeam',      'user_role' => 'trainer'],
  'poke_team_remove' => ['controller' => 'PokeTeamController', 'action' => 'removePkmFromTeam', 'user_role' => 'trainer'],
  'poke_team_add'    => ['controller' => 'PokeTeamController', 'action' => 'addPkmToTeam',      'user_role' => 'trainer'],
  'poke_team_reset'  => ['controller' => 'PokeTeamController', 'action' => 'resetPokeTeam',     'user_role' => 'trainer'],
  'logout'           => ['controller' => 'AuthController',     'action' => 'logout',            'user_role' => 'trainer'],

  'add_pokemon'      => ['controller' => 'PokemonController',  'action' => 'addPokemon',     'user_role' => 'admin'],
  'user_list'        => ['controller' => 'UserController',     'action' => 'listAll',        'user_role' => 'admin'],
  'user_list_edit'   => ['controller' => 'UserController',     'action' => 'updateUserRole', 'user_role' => 'admin'],
  'user_list_remove' => ['controller' => 'UserController',     'action' => 'deleteUser',     'user_role' => 'admin'],
];

if (isset($_GET['ctl']) && isset($routes[$_GET['ctl']])) {

  $route = $routes[$_GET['ctl']];

  $whichController = $route['controller'];
  $action          = $route['action'];

  if ($whichController && $action && class_exists($whichController) && method_exists($whichController, $action)) {
    
    // access control
    $auth = new AuthController();
    if ($auth->currentUserCan($route['user_role'])) {
      $controller = new $whichController();
      $controller->$action();

    } else {
      header('Location: index.php?ctl=home&error=401');
    }
  }

} else {
  header('Location: index.php?ctl=home');
}