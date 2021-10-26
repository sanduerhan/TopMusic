<?php

//Inicio del procesamiento
session_start();

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Contenido</title>
</head>

<body>

<div id="contenedor">

<?php
	require("cabecera.php");
	require("sidebarIzq.php");
	require("autorizacion.php");
	require("verTop.php");
?>

<main>
	<article>
	<?php
		if (!estaLogado()) {
			echo "<h1>Usuario no registrado!</h1>";
			echo "<p>Debes iniciar sesión para ver el contenido..</p>";
		} else {
	?>
		<h2>Aqui puedes ver los tops de musica, votar a tus canciones favoritas y si eres artisto añadir tus canciones</h2>
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
	$query=sprintf("SELECT id,TITLE,ARTISTA,NR_VOTOS FROM melodia ORDER BY NR_VOTOS DESC");
	$rs = $conn->query($query);
	while ($fila = mysqli_fetch_assoc($rs)) {
		//$i=1;
		?>
		<a href="addComment.php?id=<?php echo $fila['id']; ?>">
		<?php
		echo $fila['TITLE'];
		echo "  -  ";
		echo $fila['ARTISTA'];
		echo "  -  ";
		echo $fila['NR_VOTOS'];
		?>
		</a>
		<?php
		//$i++;
		echo "<br>";
	}
	if(array_key_exists('button1', $_POST)) {
		mostraTop("rock");
	}
	else if(array_key_exists('button2', $_POST)) {
		mostraTop("pop");
	}
	else if(array_key_exists('button3', $_POST)) {
		mostraTop("reggaeton");
	}
	else if(array_key_exists('button4', $_POST)) {
		mostraTop("rap");
	}

		?>
		<div style="position:absolute; top:600px;">
		<form method="post">
        <input type="submit" name="button1"
                class="button" value="TopRock" />
        <br>
        <input type="submit" name="button2"
                class="button" value="TopPop" />
				<form method="post">
				<br>
        <input type="submit" name="button3"
                class="button" value="TopReggaeton" />
				<br>
		<input type="submit" name="button4"
                class="button" value="TopRap" />
        <br>
    </form>
		<p> <button onclick="location.href='vote.php'">Votar para tu cancion favorita</button> </p>
		<p> <button onclick="location.href='addSong.php'">Nueva Cancion</button> </p>
		</div>
		
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