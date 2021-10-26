<?php

//Inicio del procesamiento
session_start();

if (! isset($_POST['vote']) ) {
	header('Location: vote.php');
	exit();
}


$erroresFormulario = array();
//echo $_POST['cancion'];
$value =isset($_POST['cancion']) ? $_POST['cancion'] : null;
//echo $value;
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
	$query=sprintf("UPDATE melodia SET NR_VOTOS=NR_VOTOS+1 WHERE TITLE LIKE '%s%%'", $conn->real_escape_string($value));
    echo $query;
		if ( $conn->query($query) ) {
			header('Location: vote.php');
			exit();
		} else {
			echo "Error al update en la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
			exit();
		}
	}		 

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Votar</title>
</head>

<body>

<div id="contenedor">

<?php
	require("cabecera.php");
	require("sidebarIzq.php");
?>
<main>
<article>

		<h2>Elige que canciones te gusta</h2>
        <form action="procesarVote.php" method="post">
		<?php
        $conn= new \mysqli('localhost', 'administrador', 'admin', 'topmusic');
        if ( $conn->connect_errno ) {
            echo "Error de conexión a la BD: (" . $conn->connect_errno . ") " . utf8_encode($conn->connect_error);
            exit();
        }
        if ( ! $conn->set_charset("utf8mb4")) {
            echo "Error al configurar la codificación de la BD: (" . $conn->errno . ") " . utf8_encode($tconn->error);
            exit();
        }
            $query=sprintf("SELECT TITLE,ARTISTA FROM melodia ");
            $rs = $conn->query($query);
            while ($fila = mysqli_fetch_assoc($rs)) {
                
                echo "<input type='radio' name='cancion', value= " . $fila['TITLE'] . ">";
                echo $fila['TITLE'];
                echo "  -  ";
                echo $fila['ARTISTA'] ."<br>";
                
            }
		?>
        <input type='submit' name='vote' value='Vote' />
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