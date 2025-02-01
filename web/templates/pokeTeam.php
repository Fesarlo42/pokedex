<?php

ob_start();

?>

<div class="container py-5" id="poke_team">
  <div>
    <h2 class="my-4">Tu equipo Pokemon</h2>
    <p>Gestiona tu equipo Pokemon: Pincha en la bolita con el "+" apara añadir un nuevo miembro a tu equipo, o pincha en un miembro que ya existe para eliminarlo.</p>
  </div>

  <div class="row justify-content-center align-items-center">
    <?php 
    // Ensure there is a poke team array
    $pokeTeam = $params['pokeTeam'] ?? [];
    $maxPkem = 6; // the max number o pokemon in a team

    for ($i = 0; $i < $maxPkem; $i++): ?>
      <div class="col-md-2 text-center">
        <?php if (isset($pokeTeam[$i])): ?>
          <!-- Pokemon -->
          <form method="POST" action="index.php?ctl=poke_team_remove">
              <input type="hidden" name="poke_id" value="<?php echo $pokeTeam[$i]['id']; ?>">
              <button type="submit" class="btn p-0 border-0 bg-transparent" name="deleteFromTeam">
                  <img src="<?php echo $pokeTeam[$i]['gif']; ?>" alt="<?php echo $pokeTeam[$i]['name']; ?>" style="width: 80px; height: 80px;">
              </button>
          </form>
        <?php else: ?>
          <!-- Empty place to add a Pokemon -->
          <div class="d-flex justify-content-center align-items-center rounded-circle bg-secondary text-white" 
              style="width: 80px; height: 80px; cursor: pointer; font-size: 24px;" 
              data-bs-toggle="modal" data-bs-target="#addPokemonModal">
            +
          </div>
        <?php endif; ?>
      </div>
    <?php endfor; ?>
</div>

<div class="row justify-content-end my-5">
  <form method="POST" action="index.php?ctl=poke_team_reset">
      <button type="submit" class="btn btn-primary ms-2 rounded-pill" name="resetTeamBtn">Redefinir equipo</button>
  </form>
</div>

<!-- Modal for adding a Pokemon -->
<div class="modal fade" id="addPokemonModal" tabindex="-1" aria-labelledby="addPokemonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPokemonModalLabel">¿Cual Pokemon quieres añadir a tu equipo?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="index.php?ctl=poke_team_add" method="POST" class="d-flex justify-content-center">
                <?php if(count($params['pokemons']) !== 0): ?>
                <select name="poke_id" class="form-select w-auto">
                  <option value="" disabled selected>Selecciona un Pokemon</option>
                    <?php foreach ($params['pokemons'] as $pkm): ?>
                      <option value="<?php echo $pkm['id']; ?>"><?php echo $pkm['name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <?php endif;?>
                  <button type="submit" class="btn btn-primary ms-2 rounded-pill" name="addToTeam">Añadir</button>
              </form>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>