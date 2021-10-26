<?php

//Inicio del procesamiento
session_start();

if (! isset($_POST['addComment']) ) {
	header('Location: addComment.php');
	exit();
}


$erroresFormulario = array();

$mensaje = isset($_POST['mensaje']) ? $_POST['mensaje'] : null;
if ( empty($mensaje) ) {
	$erroresFormulario[] = "El mensaje no puede estar vacío.";
}
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
	if(isset($_POST['id_melodia']) && isset($_POST['id_usuario']))
   {
        $id_mel = $_POST['id_melodia'];
        $id_user = $_POST['id_usuario'];
    }
	$query=sprintf("INSERT INTO comentario(ID_USUARIO, ID_MELODIA, COMENTARIO) VALUES('%d', '%d', '%s')"
					, $id_user
					, $id_mel
					, $conn->real_escape_string($mensaje));
			if ( $conn->query($query) ) {
				header('Location: addComment.php');
				exit();
			} else {
				echo "Error al insertar en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
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
    require("autorizacion.php");
?>

<main>
	<article>
    <?php
		if (estaLogado()===false) {
			echo "<h1>Acceso denegado!</h1>";
			echo "<p>No tienes permisos suficientes para hacer un comentario.</p>";
		} else { 
	?>
		<h1>Añadir comentario</h1>

		<form action="procesarComment.php" method="POST">
		<fieldset>
			<div class="grupo-control">
            <textarea title="Contenido" class="grupo-control" name="mensaje" 
                            placeholder="Contenido" required></textarea>
			</div>
			<div class="grupo-control"><button type="submit" name="addComment">Enviar</button></div>
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
