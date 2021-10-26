<?php

//Inicio del procesamiento
session_start();

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
		<fieldset>
			<div class="grupo-control">
				<label>Nombre de usuario:</label> <input class="control" type="text" name="username" />
			</div>
			<div class="grupo-control">
				<label>Password:</label> <input class="control" type="password" name="password" />
			</div>
			<div class="grupo-control"><label>Vuelve a introducir el Password:</label> <input class="control" type="password" name="password2" /><br /></div>
			<select title="Rol" class="grupo-control" name="rol" required>
                                <option selected>Rol</option>
                                <option value="usuario">Usuario Regular</option>
                                <option value="artisto">Artisto</option>
                            </select>
			<div class="grupo-control"><button type="submit" name="registro">Registrar</button></div>
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