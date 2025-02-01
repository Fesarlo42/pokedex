<?php

ob_start();

?>

<div class="container py-5" id="login">
  <div><h2 class="my-4">Acceder</h2></div>
  <div class="row justify-content-center align-items-center">
    <div class="col-md-6">
      <div class="card mt-5">
        <div class="card-body">
          <form action="index.php?ctl=login" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">E-mail *</label>
              <input type="text" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña *</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" name="loginBtn" class="btn btn-primary w-100">Acceder</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>