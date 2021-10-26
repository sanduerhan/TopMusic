<?php

//Inicio del procesamiento
session_start();

if (! isset($_POST['login']) ) {
	header('Location: login.php');
	exit();
}


$erroresFormulario = array();

$username = isset($_POST['username']) ? $_POST['username'] : null;

if ( empty($username) ) {
	$erroresFormulario[] = "El nombre de usuario no puede estar vacío";
}

$password = isset($_POST['password']) ? $_POST['password'] : null;
if ( empty($password) ) {
	$erroresFormulario[] = "El password no puede estar vacío.";
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
	
	$query=sprintf("SELECT * FROM usuario U WHERE U.username = '%s'", $conn->real_escape_string($username));
	$rs = $conn->query($query);
	if ($rs) {
		if ( $rs->num_rows == 0 ) {
			// No se da pistas a un posible atacante
			$erroresFormulario[] = "El usuario o el password no coinciden";
		} else {
			$fila = mysqli_fetch_assoc($rs);
			if ( ! password_verify($password, $fila['PASSWORD'])) {
				$erroresFormulario[] = "El usuario o el password no coinciden";
			} else {
				$_SESSION['login'] = true;
				$_SESSION['nombre'] = $username;
				$_SESSION['rol'] = $fila['ROL'];
				$query=sprintf("SELECT id FROM usuario WHERE USERNAME='%s'", $username);
				$rs = $conn->query($query);
				$fila = mysqli_fetch_assoc($rs);
				$_SESSION['id'] = $fila['id'];
				header('Location: index.php');
				exit();
			}
		}
		$rs->free();
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
<title>Login</title>
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
		if (isset($_SESSION["login"])) {
			echo "<h1>Bienvenido ". $_SESSION['nombre'] . "</h1>";
			echo "<p>Usa el menú de la izquierda para navegar.</p>";
		} else {
			echo "<h1>ERROR</h1>";
            if (count($erroresFormulario) > 0) {
                echo '<ul class="errores">';
            }
            foreach($erroresFormulario as $error) {
                echo "<li>$error</li>";
            }
            if (count($erroresFormulario) > 0) {
                echo '</ul>';
            }
	?>
		<form action="procesarLogin.php" method="POST">
		<fieldset>
            <legend>Usuario y contraseña</legend>
            <div class="grupo-control">
                <label>Nombre de usuario:</label> <input type="text" name="username" value="<?= $username ?>" />
            </div>
            <div class="grupo-control">
                <label>Password:</label> <input type="password" name="password" value="<?= $password ?>" />
            </div>
            <div class="grupo-control"><button type="submit" name="login">Entrar</button></div>
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