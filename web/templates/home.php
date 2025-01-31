<?php

ob_start();

?>

<?php
ob_start();
?>

<div class="container text-center mt-5 py-5" id="home">
    <img src="../web/images/logo.png" alt="Pokedex" class="img-fluid mb-4" style="max-width: 300px;">

    <h3 class="mb-3">Busca información de tu Pokémon favorito</h3>
    <form action="index.php?ctl=pokemon" method="POST" class="d-flex justify-content-center">
        <input type="text" name="pokemon" class="form-control w-50 rounded-pill" placeholder="Ejemplo: Pikachu, Charizard..." required>
        <button type="submit" class="btn btn-primary ms-2 rounded-pill">Buscar</button>
    </form>
</div>

<?php $content = ob_get_clean() ?>

<?php include 'layout.php' ?>