<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Encuentra información sobre tus Pokemon favoritos y monta tu propio equipo.">
  <meta name="author" content="Fernanda Gomes Sarlo">
  <link rel="shortcut icon" href="../web/images/favicon.png" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../web/assets/styles.css">
  <title>Pokedex</title>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <?php	include 'menu.php'; ?>

  <?php	include 'messages.php'; ?>

  <div class="container-fluid">
		<div class="container">
			<div id="content" class="my-4">
			<?php echo $content ?>
			</div>
		</div>
	</div>
</body>
</html>