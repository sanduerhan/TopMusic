<?php

session_start();

if (! isset($_POST['registro']) ) {
	header('Location: registro.php');
	exit();
}


$erroresFormulario = array();

$username = isset($_POST['username']) ? $_POST['username'] : null;

if ( empty($username) || mb_strlen($username) < 5 ) {
	$erroresFormulario[] = "El nombre de usuario tiene que tener una longitud de al menos 5 caracteres.";
}

$password = isset($_POST['password']) ? $_POST['password'] : null;
if ( empty($password) || mb_strlen($password) < 5 ) {
	$erroresFormulario[] = "El password tiene que tener una longitud de al menos 5 caracteres.";
}
$password2 = isset($_POST['password2']) ? $_POST['password2'] : null;
if ( empty($password2) || strcmp($password, $password2) !== 0 ) {
	$erroresFormulario[] = "Los passwords deben coincidir";
}

$rol = isset($_POST['rol']) ? $_POST['rol'] : null;

if (count($erroresFormulario) === 0) {
	$conn = new \mysqli('localhost', 'administrador', 'admin', 'topmusic');
	if ( $conn->connect_errno ) {
		echo "Error de conexión a la BD: (" . $this->conn->connect_errno . ") " . utf8_encode($this->conn->connect_error);
		exit();
	}
	if ( ! $conn->set_charset("utf8mb4")) {
		echo "Error al configurar la codificación de la BD: (" . $this->conn->errno . ") " . utf8_encode($this->conn->error);
		exit();
	}
	
	$query=sprintf("SELECT * FROM Usuario U WHERE U.username = '%s'", $conn->real_escape_string($username));
	$rs = $conn->query($query);
	if ($rs) {
		if ( $rs->num_rows > 0 ) {
			$erroresFormulario[] = "El usuario ya existe";
			$rs->free();
		} else {
			$query=sprintf("INSERT INTO Usuario(username, password, rol) VALUES('%s', '%s', '%s')"
					, $conn->real_escape_string($username)
					, password_hash($password, PASSWORD_DEFAULT)
					, $rol);
			if ( $conn->query($query) ) {
				$_SESSION['login'] = true;
				$_SESSION['nombre'] = $username;
				$_SESSION['rol'] = $rol;
				$query=sprintf("SELECT id FROM usuario WHERE USERNAME='%s'", $username);
				$rs = $conn->query($query);
				$fila = mysqli_fetch_assoc($rs);
				$_SESSION['id'] = $fila['id'];
				header('Location: index.php');
				exit();
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
<title>Registro</title>
</head>

<body>

<div id="contenedor">

<?php
	require("cabecera.php");
	require("sidebarIzq.php");
?>

<main>
	<article>
		<h1>Registro de usuario</h1>
		
		<form action="procesarRegistro.php" method="POST">	
<?php
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
		</ul>
		<fieldset>
			<div class="grupo-control">
				<label>Nombre de usuario:</label> <input class="control" type="text" name="username" value="<?=$username ?>" />
			</div>
			<div class="grupo-control">
				<label>Password:</label> <input class="control" type="password" name="password" />
			</div>
			<div class="grupo-control"><label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" /><br /></div>
			<select title="Rol" class="grupo-control" name="rol" required>
                                <option selected>Rol</option>
                                <option value="registrado">Usuario Regular</option>
                                <option value="artisto">Artisto</option>
                            </select>
			<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
		</fieldset>
	</article>
</main>

<?php
	require("sidebarDer.php");
	require("pie.php");
?>


</div>

</body>
</html>