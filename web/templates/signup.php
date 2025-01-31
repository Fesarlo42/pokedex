<?php
var_dump($params);


ob_start();

$extensions_mime = '';
foreach (Config::$allowed_profile_extensions as $extension) {
  $extensions_mime .= 'image/' . $extension . ', ';
}

?>

<div class="container py-5" id="signup">
  <div><h2 class="my-4">Registro</h2></div>
  <div class="row justify-content-center align-items-center">
    <div class="col-md-6">
      <div class="card mt-5">
        <div class="card-body">
          <form action="index.php?ctl=signup" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="name" class="form-label">Nombre *</label>
              <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña *</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="profile_pic" class="form-label">Foto de perfil</label>
              <input type="file" name="profile_pic" id="profile_pic" class="form-control" accept="<?php echo $extensions_mime; ?>" >
            </div>
            <button type="submit" name="registerBtn" class="btn btn-primary w-100">Registrarme</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>