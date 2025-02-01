<?php

ob_start();

?>

<div class="container py-5" id="user_list">
  <div><h2 class="my-4">Lista de Usuarios</h2></div>
  <div class="row justify-content-center align-items-center">
    <?php if(isset($params['users']) && count($params['users']) !== 0): ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>E-mail</th>
            <th>Perfil</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($params['users'] as $user) : ?>
            <tr>
              <td style="width: 10%;"><?php echo '#' . $user['id']; ?></td>
              <td style="width: 10%;"><img src="<?php echo $user['profile_picture']; ?>" alt="<?php echo $user['name']; ?> Sprite" width="50px"></td>
              <td><?php echo $user['name']; ?></td>
              <td><?php echo $user['email']; ?></td>
              <td style="width: 20%;"><?php echo $user['role']; ?>
                
                <div id="roleUpdateForm-<?php echo $user['id']; ?>" class="collapse">
                  <form action="index.php?ctl=user_list_edit" method="POST" class="d-flex justify-content-center">
                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                    <select name="new_role" class="form-select w-auto">
                      <option value="" disabled selected>Selecciona un perfil</option>
                      <option value="trainer">Entrenador</option>
                      <option value="admin">Administrador</option>
                    </select>
                    <button type="submit" class="btn btn-primary ms-2 rounded-pill" name="updateRoleBtn">Cambiar</button>
                  </form>
                </div>

              </td>
              <td style="width: 10%;">
                <button class="btn btn-warning" data-bs-toggle="collapse" data-bs-target="#roleUpdateForm-<?php echo $user['id']; ?>" aria-expanded="false" aria-controls="roleUpdateForm-<?php echo $user['id']; ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar perfil">
                  <i class="bi bi-pencil"></i>
                </button>
              </td>
              <td style="width: 10%;">
                <form method="POST" action="index.php?ctl=user_list_remove">
                  <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                  <button type="submit" name="deleteUserBtn" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Remover usuario">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
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