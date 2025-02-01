<?php 

$auth = new AuthController();

?>

<nav class="navbar navbar-light bg-light px-4">
  <div class="container-fluid d-flex align-items-center">
    <a class="navbar-brand" href="<?php echo $_SERVER['SCRIPT_NAME']; ?>?ctl=home">
      <img src="../web/images/logo.png" width="120px" alt="Pokedex" class="d-inline-block align-text-top">
    </a>

    <ul class="nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php?ctl=home">Inicio</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="index.php?ctl=pokemon_list">Listado de Pokemon</a>
      </li>
      
       <?php if(!$auth->isLoggedIn()): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?ctl=signup">Registro</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="index.php?ctl=login">Acceder</a>
      </li>
      <?php endif; ?>

      <?php if($auth->isLoggedIn()): ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?ctl=poke_team">Tu equipo</a>
      </li>
        <?php if($auth->currentUserCan('admin')): ?>
        <li class="nav-item">
          <a class="nav-link" href="index.php?ctl=add_pokemon">Añadir pokemon</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="index.php?ctl=user_list">Administrar usuarios</a>
        </li>
        <?php endif; ?>
      <li class="nav-item">
        <a class="nav-link" href="index.php?ctl=logout">Salir</a>
      </li>
      <?php endif; ?>
    </ul>
    
    <div class="d-flex align-items-center ms-auto">
      <?php if($auth->isLoggedIn()): 
        
        $userContrl = new UserController();
        $user = $userContrl->getUserData();

        ?>
      <span class="me-2">Bienvenido <?php echo $user["role"] == 'admin' ? 'administrador' : 'entrenador'; ?> <?php echo $user["name"]; ?></span>
      <img
        src="<?php echo $user["profile_picture"]; ?>"
        alt="Profile Picture"
        class="rounded-circle"
        width="40"
        height="40"
      >
      <?php endif; ?>
    </div>
    
  </div>
</nav>