<?php

ob_start();

$img_mime = '';
foreach (Config::$allowed_image_extensions as $extension) {
  $img_mime .= 'image/' . $extension . ', ';
}

?>

<div class="container py-5" id="add_pokemon">
  <div><h2 class="my-4">Añadir nuevo pokemon</h2></div>
  <div class="row justify-content-center align-items-center">
    <div class="col-md-6">
      <div class="card mt-5">
        <div class="card-body">
          <form action="index.php?ctl=add_pokemon" method="POST" enctype="multipart/form-data">

            <div  class="row justify-content-center align-items-center">
              <div class="mb-3 col-md-2">
                <label for="poke_id" class="form-label">ID *</label>
                <input type="text" name="poke_id" id="poke_id" class="form-control" required>
              </div>
  
              <div class="mb-3 col-md-10">
                <label for="poke_name" class="form-label">Nombre *</label>
                <input type="text" name="poke_name" id="poke_name" class="form-control" required>
              </div>
            </div>

            <div class="d-flex mb-3">
              <?php if(count($params['types']) !== 0): ?>
                <select name="type_1" class="form-select w-auto" required>
                  <option value="" disabled selected>Selecciona el tipo principal</option>
                  <?php foreach ($params['types'] as $type): ?>
                    <option value="<?= htmlspecialchars($type); ?>"><?= htmlspecialchars($type); ?></option>
                  <?php endforeach; ?>
                </select>
  
                <select name="type_2" class="form-select w-auto">
                  <option value="" disabled selected>Selecciona el tipo secundario si hay</option>
                  <?php foreach ($params['types'] as $type): ?>
                    <option value="<?= htmlspecialchars($type); ?>"><?= htmlspecialchars($type); ?></option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Descripción *</label>
              <textarea name="description" id="description" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
              <label for="poke_artwork" class="form-label">Imagen principal *</label>
              <input type="file" name="poke_artwork" id="poke_artwork" class="form-control" accept="<?php echo $img_mime; ?>" required>
            </div>

            <div class="mb-3">
              <label for="poke_sprite" class="form-label">Sprite *</label>
              <input type="file" name="poke_sprite" id="poke_sprite" class="form-control" accept="<?php echo $img_mime; ?>" required>
            </div>

            <div class="mb-3">
              <label for="poke_gif" class="form-label">Gif *</label>
              <input type="file" name="poke_gif" id="poke_gif" class="form-control" accept="image/gif" required>
            </div>

            <button type="submit" name="addPokemonBtn" class="btn btn-primary w-100">Añadir pokemon</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>