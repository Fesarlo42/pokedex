<?php
ob_start();

?>
<div class="container py-5" id="pokemon">
  <div><h2 class="my-4">Detalles del pokemon</h2></div>
  <div class="row justify-content-center align-items-center">
    <?php if(isset($params['pokemon']) && count($params['pokemon']) !== 0): ?>
    <div class="col-md-6 text-center">
      <div class="position-relative">
        <img src="<?php echo $pokemon['artwork']; ?>" alt="<?php echo $pokemon['name'] ?> Oficial Artwork" class="img-fluid mb-3">
      </div>
    </div>

    <div class="col-md-6">
      <h2><?php echo $pokemon['name']; ?></h2>
      
      <div class="mb-3 ">
        <img src="<?php echo '../web/images/types/' . $pokemon['type_1'] . '.png'; ?>">
          <?php if ($pokemon['type_2']) : ?>
              <img src="<?php echo '../web/images/types/' . $pokemon['type_2'] . '.png'; ?>">
          <?php endif; ?>
        </div>
        
      <p><?php echo $pokemon['description']; ?></p>
    </div>
    <?php else: ?>
      <img src="../web/images/404.png" alt="No encontrado" style="width:400px;">
      <h2 class="text-center">404 - No encontrado</h2>
    <?php endif; ?>
  </div>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>