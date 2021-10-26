<?php

//Inicio del procesamiento
session_start();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Administrar</title>
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
		if (esAdmin()==true) {
	?>
		<h1>Consola de administración</h1>
		<p>Aquí estarían todos los controles de administración</p>
		<p>Estos son todos los artistos que se han registrado:</p>
		<?php
		$conn= new \mysqli('localhost', 'administrador', 'admin', 'topmusic');
		if ( $conn->connect_errno ) {
			echo "Error de conexión a la BD: (" . $conn->connect_errno . ") " . utf8_encode($conn->connect_error);
			exit();
		}
		if ( ! $conn->set_charset("utf8mb4")) {
			echo "Error al configurar la codificación de la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
			$query=sprintf("SELECT USERNAME FROM usuario WHERE ROL='artisto'");
			$rs = $conn->query($query);
			while ($fila = mysqli_fetch_assoc($rs)) {
				echo $fila['USERNAME'];
				echo "<br>";
			}
		} else {
	?>
		<h1>Acceso denegado!</h1>
		<p>No tienes permisos suficientes para administrar la web.</p>
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