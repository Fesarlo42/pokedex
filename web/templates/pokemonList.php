<?php

ob_start();

?>

<div class="container py-5" id="pokemon_list">
  <div><h2 class="my-4">Lista de Pokemon</h2></div>
  <div class="row justify-content-center align-items-center">
    <?php if(isset($params['pokemons']) && count($params['pokemons']) !== 0): ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Icono</th>
            <th>Nombre</th>
            <th>Tipos</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pokemons as $pokemon) : ?>
            <tr>
              <td style="width: 10%;"><?php echo '#' . $pokemon['id']; ?></td>
              <td style="width: 10%;"><img src="<?php echo $pokemon['sprite']; ?>" alt="<?php echo $pokemon['name']; ?> Sprite" width="50px"></td>
              <td>
                <form action="index.php?ctl=pokemon" method="POST" class="d-flex justify-content-center">
                  <button type="submit" name="pokemon" value="<?php echo $pokemon['name']; ?>" class="btn btn-link p-0">
                    <?php echo $pokemon['name']; ?>
                  </button>
                </form>
              </td>
              <td style="width: 20%;">
                <?php
                echo $pokemon['type_1'];
                if (!empty($pokemon['type_2'])) {
                    echo ' / ' . $pokemon['type_2'];
                }
                ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <img src="../web/images/404.png" alt="No encontrado" style="width:400px;">
      <h2 class="text-center">404 - No encontrado</h2>
    <?php endif; ?>
  </div>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>