<?php

//Inicio del procesamiento
session_start();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Nueva cancion</title>
</head>

<body>

<div id="contenedor">

<?php
	require("cabecera.php");
	require("sidebarIzq.php");
    require("autorizacion.php");
?>

<main>
	<article>
    <?php
		if (esAdmin()===false && esArtisto()===false) {
			echo "<h1>Acceso denegado!</h1>";
			echo "<p>No tienes permisos suficientes para anadir una cancion.</p>";
		} else { 
	?>
		<h1>Añadir cancion</h1>

		<form action="procesarAddSong.php" method="POST">
		<fieldset>
			<div class="grupo-control">
				<label>Titulo:</label> <input class="control" type="text" name="titulo" />
			</div>
			<div class="grupo-control">
				<label>Artisto:</label> <input class="control" type="text" name="artisto" />
			</div>
			<select title="genre" class="grupo-control" name="gen" required>
                                <option selected>Genre</option>
                                <option value="pop">Pop</option>
                                <option value="rock">Rock</option>
                                <option value="rap">Rap</option>
                                <option value="reggaeton">Reggaeton</option>
                            </select>
			<div class="grupo-control"><button type="submit" name="addSong">Enviar</button></div>
		</fieldset>
		</form>
        <?php
		}
	?>
	</article>
</main>
<?php
	require("sidebarDer.php");
	require("pie.php");
?>


</div>

</body>
</html>