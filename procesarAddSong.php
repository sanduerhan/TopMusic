<?php

//Inicio del procesamiento
session_start();

if (! isset($_POST['addSong']) ) {
	header('Location: addSong.php');
	exit();
}


$erroresFormulario = array();

$titulo = isset($_POST['titulo']) ? $_POST['titulo'] : null;

if ( empty($titulo) ) {
	$erroresFormulario[] = "El titulo de la melodia no puede estar vacío";
}

$artisto = isset($_POST['artisto']) ? $_POST['artisto'] : null;
if ( empty($artisto) ) {
	$erroresFormulario[] = "El artisto no puede estar vacío.";
}

$gen = isset($_POST['gen']) ? $_POST['gen'] : null;
if (count($erroresFormulario) === 0) {
	$conn= new \mysqli('localhost', 'administrador', 'admin', 'topmusic');
	if ( $conn->connect_errno ) {
		echo "Error de conexión a la BD: (" . $conn->connect_errno . ") " . utf8_encode($conn->connect_error);
		exit();
	}
	if ( ! $conn->set_charset("utf8mb4")) {
		echo "Error al configurar la codificación de la BD: (" . $conn->errno . ") " . utf8_encode($tconn->error);
		exit();
	}
	
	$query=sprintf("SELECT * FROM melodia M WHERE M.TITLE = '%s'", $conn->real_escape_string($titulo));
	$rs = $conn->query($query);
	if ($rs) {
		if ( $rs->num_rows > 0 ) {
			$erroresFormulario[] = "El titulo ya existe";
			$rs->free();
		} else {
			$query=sprintf("INSERT INTO genre(title, artista, gen) VALUES('%s', '%s', '%s')"
					, $conn->real_escape_string($titulo)
					, $conn->real_escape_string($artisto)
					, $gen);
			if ( $conn->query($query) ) {
				$query=sprintf("INSERT INTO melodia(title, artista, nr_votos) VALUES('%s', '%s', '%d')"
					, $conn->real_escape_string($titulo)
					, $conn->real_escape_string($artisto)
					, 0);
				if($conn->query($query))
				{
				header('Location: addSong.php');
				exit();
				}
			} else {
				echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
				exit();
			}
		}		
	} else {
		echo "Error al consultar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
		exit();
	}
}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Anadir</title>
</head>

<body>

<div id="contenedor">

<?php
	require("cabecera.php");
	require("sidebarIzq.php");
?>

<main>
	<article>
	<?php
		echo "<h2>Has anadido la cancion con exito</h2>";
	?>
    <form action="procesarAddSong.php" method="POST">
		<fieldset>
			<div class="grupo-control">
				<label>Titulo:</label> <input class="control" type="text" name="titulo" />
			</div>
			<div class="grupo-control">
				<label>Artisto:</label> <input class="control" type="text" name="artisto" />
			</div>
			<select title="gen" class="grupo-control" name="gen" required>
                                <option selected>Genre</option>
                                <option value="pop">Pop</option>
                                <option value="rock">Rock</option>
                                <option value="rap">Rap</option>
                                <option value="reggaeton">Reggaeton</option>
                            </select>
			<div class="grupo-control"><button type="submit" name="addSong">Enviar</button></div>
		</fieldset>
		</form>
	</article>
</main>

<?php
	require("sidebarDer.php");
	require("pie.php");
?>
</div>

</body>
</html>
