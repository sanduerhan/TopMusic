<?php

//Inicio del procesamiento
session_start();

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="estilo.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Portada</title>
</head>

<body>

<div id="contenedor">

<?php
	require("cabecera.php");
	require("sidebarIzq.php");
?>
	<main>
		<article>
			<h1>Página principal</h1>
			<p> Aquí están las noticias principales del mundo de musica. </p>
			<p><a href=https://www.nme.com/news/music/noel-gallagher-liam-hated-wonderwall-he-said-it-was-trip-hop-2942349>
			<img src="download.jpg" alt="Oasis">
			</a></p>
		</article>
	</main>
<?php

	require("sidebarDer.php");
	require("pie.php");

?>
</div>

</body>
</html>