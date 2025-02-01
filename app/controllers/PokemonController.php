<?php

class PokemonController {
  private $pokemonModel;

  public function __construct() {
    $this->pokemonModel = new Pokemon();
  }

  /**
   * Lists all Pokemon.
   *
   * @return void
   */
  public function listPokemons(): void {
    try {
      // get all pokemon
      $pokemons = $this->pokemonModel->listAll();

      if(count($pokemons) == 0) {
        $params = [
          'message' => 'No se encontraron Pokemon en la base de datos.'
        ];
      } else {
        $params = [
          'pokemons' => $pokemons
        ];
      }

    } catch (Exception $e) {
      error_log("Pokemon listing error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
      header('Location: index.php?ctl=error');
      exit;
    }

    // get the template
    include ROOT_PATH . '/web/templates/pokemonList.php';
  }

  /**
   * Gets a Pokemon by name.
   *
   * @return void
   */
  public function getPokemon(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pokemon'])) {
      $name = recoge('pokemon');

      try {
        // get the pokemon
        $pokemon = $this->pokemonModel->find($name);

        if($pokemon === false) {
          $params = [
            'pokemon' => [],
            'message' => 'No se encontró el Pokemon ' . $name . ' en la base de datos.'
          ];
        } else {
          $params = [
            'pokemon' => $pokemon
          ];
        }

      } catch (Exception $e) {
        error_log("Pokemon finding error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
      
    } else {
      $params = [
        'message' => 'Hubo un error al intentar obtener el Pokemon. Vuelve a intentarlo más tarde.'
      ];
      include ROOT_PATH . '/web/templates/pokemon.php';
      exit;
    }
    
    // get the template
    include ROOT_PATH . '/web/templates/pokemon.php';
  }

  /**
   * Adds a new Pokemon.
   * Checks for admin role
   *
   * @return void
   */
  public function addPokemon(): void {
    $auth = new AuthController();
    if(!$auth->currentUserCan('admin')) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    $params['types'] = $this->pokemonModel->getPokeTypes();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addPokemonBtn'])) {
      $params['errors'] = [];

      // first validate texts
      $poke_id = recoge('poke_id');
      $name    = recoge('poke_name');
      $type_1  = recoge('type_1');
      if(isset($_POST['type_2'])) {
        $type_2 = recoge('type_2');
      } else {
        $type_2 = null;
      }
      $description = recoge('description');

      $errors = [];
      cNum($poke_id, 'poke_id', $errors, 1);
      if(!$name) {
        $errors['name'] = 'El nombre del Pokemon es requerido.';
      }
      cTexto($name, 'poke_name', $errors, 30, 3);
      cCheck([$type_1], 'type_1', $errors, $this->pokemonModel->getPokeTypes(), true);
      if (isset($type_2)) {
        cCheck([$type_2], 'type_2', $errors, $this->pokemonModel->getPokeTypes(), false);
      }
      
      if(!isset($_POST['description'])) {
        $errors['description'] = "La descripción es obligatoria.";
      }

      if(!empty($errors)) {
        $params['errors'] = $errors;

        include ROOT_PATH . '/web/templates/pokemonAdd.php';
        exit;
      }

      // validate files if its all right
      $artwork_path = cFile('poke_artwork', $errors, Config::$allowed_image_extensions, Config::$images_artworks_path, Config::$max_file_size, true);
      $sprite_path = cFile('poke_sprite', $errors, Config::$allowed_image_extensions, Config::$images_sprites_path, Config::$max_file_size, true);
      if(isset($_FILES['gif'])) {
        $gif_path = cFile('poke_gif', $errors, Config::$allowed_animation_extensions, Config::$images_gifs_path, Config::$max_file_size, false);
      } else {
        $gif_path = null;
      }

      if(!empty($errors)) {
        $params['errors'] = $errors;

        include ROOT_PATH . '/web/templates/pokemonAdd.php';
        exit;
      }

      try {
        // create slug
        $slug = strtolower($name);
        $slug = str_replace(' ', '-', $slug);

        // add the pokemon
        $result = $this->pokemonModel->add($poke_id, $name, $slug, $type_1, $type_2, $description, $artwork_path, $sprite_path, $gif_path);

        if($result === false) {
          $params['message'] = 'Hubo un error al intentar agregar el Pokemon. Vuelve a intentarlo más tarde.';
        } else {
          $params['message'] = 'El Pokemon ' . $name . ' fue agregado exitosamente.';
        }

      } catch (Exception $e) {
        error_log("Pokemon adding error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
      
    }

    include ROOT_PATH . '/web/templates/pokemonAdd.php';
  }

  /**
   * Deletes a Pokemon by ID.
   * Checks for admin role
   *
   * @return void
   */
  public function deletePokemon(): void {
    $auth = new AuthController();
    if(!$auth->currentUserCan('admin')) {
      header('Location: index.php?ctl=home&error=401');
      exit;
    }

    $params = [
      'errors' => [],
      'message' => ''
    ];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_pokemon'])) {
      // first validate inputs
      $poke_id = recoge('poke_id');

      $errors = [];
      cNum($poke_id, 'poke_id', $errors, 1);

      if(!empty($errors)) {
        $params = [
          'errors' => $errors,
        ];
        include ROOT_PATH . '/web/templates/pokemonAdd.php';
        exit;
      }

      try {
        // delete the pokemon
        $result = $this->pokemonModel->delete($poke_id);

        // should also delete the images from the server but I don't want to loose them in testing
        /*
        if(file_exists(Config::$images_artworks_path . $poke_id . '.png')) {
          unlink(Config::$images_artworks_path . $poke_id . '.png');
        }
        if(file_exists(Config::$images_sprites_path . $poke_id . '.png')) {
          unlink(Config::$images_sprites_path . $poke_id . '.png');
        }
        if(file_exists(Config::$images_gifs_path . $poke_id . '.gif')) {
          unlink(Config::$images_gifs_path . $poke_id . '.gif');
        }
        */
        
        $params = [
          'message' => 'El Pokemon se ha borrado exitosamente.'
        ];

      } catch (PokemonNotFoundException $e) {
        $params = [
          'message' => 'El Pokemon con el ID ' . $poke_id . ' no existe en la base de datos.'
        ];
      } catch (Exception $e) {
        error_log("Pokemon deleting error: " . $e->getMessage() . microtime() . PHP_EOL, 3, "../app/logs/error_logs.txt");
        header('Location: index.php?ctl=error');
        exit;
      }
    }

    include ROOT_PATH . '/web/templates/pokemonList.php';
  }
} 