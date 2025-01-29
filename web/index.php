<?php

// require libraries
require_once __DIR__ . '/../app/libs/Config.php';
require_once __DIR__ . '/../app/libs/bGeneral.php';
require_once __DIR__ . '/../app/libs/CustomExceptions.php';

// require models
require_once __DIR__ . '/../app/models/DatabaseConnection.php';
require_once __DIR__ . '/../app/models/Pokemon.php';
require_once __DIR__ . '/../app/models/Authentication.php';
require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '../app/models/PokeTeam.php';

// require controllers
require_once __DIR__ . '/../app/models/PokemonController.php';
require_once __DIR__ . '/../app/models/AuthController.php';
require_once __DIR__ . '/../app/models/UserController.php';
require_once __DIR__ . '../app/models/PokeTeamController.php';

// start session
session_start();

// check user login status
if( !isset($_SESSION['user']) ) {
    $_SESSION['user'] = 'guest';
}


