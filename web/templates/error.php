<?php

ob_start();

?>

<div class="container py-5" id="error">
  <div><h2 class="my-4 text-center">Ups, algo no cuadra...</h2></div>
  <div class="row justify-content-center align-items-center">
    <img src="../web/images/error.png" alt="Error fatal" style="width:400px;">
      <h2 class="text-center">Se ha producido un error fatal</h2>
      <p class="text-center"><a href="/index?ctl=home">Volver al inicio</a></p>
  </div>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>