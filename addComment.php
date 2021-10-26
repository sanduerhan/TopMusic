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
		if (estaLogado()===false) {
			echo "<h1>Acceso denegado!</h1>";
			echo "<p>No tienes permisos suficientes para hacer un comentario.</p>";
		} else if(isset($_GET['id'])){ 
            $i = $_GET['id'];
            $conn= new \mysqli('localhost', 'administrador', 'admin', 'topmusic');
            if ( $conn->connect_errno ) {
                echo "Error de conexión a la BD: (" . $conn->connect_errno . ") " . utf8_encode($conn->connect_error);
                exit();
            }
            if ( ! $conn->set_charset("utf8mb4")) {
                echo "Error al configurar la codificación de la BD: (" . $conn->errno . ") " . utf8_encode($conn->error);
                exit();
            }
                $query=sprintf("SELECT ID_USUARIO, COMENTARIO FROM COMENTARIO WHERE ID_MELODIA=%d", $i);
                $rs = $conn->query($query);
                while ($fila = mysqli_fetch_assoc($rs)) {
                    $query2=sprintf("SELECT USERNAME FROM usuario WHERE id=%d", $fila['ID_USUARIO']); 
                    $rs2 = $conn->query($query2);
                    $fila2 = $rs2->fetch_assoc();
                    echo $fila2['USERNAME'];
                    echo "  -  ";
                    echo $fila['COMENTARIO'];
                    echo "<br>";
                } 
             
	?>
		<h1>Añadir comentario</h1>
		<form action="procesarComment.php" method="POST">
		<fieldset>
        <input type="hidden" name="id_melodia" value="<?=$i;?>" />
        <input type="hidden" name="id_usuario" value="<?=$_SESSION['id'];?>" />
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