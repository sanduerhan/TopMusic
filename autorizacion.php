<?php

function estaLogado(): bool {
    return isset($_SESSION['login']);
}


function esUsuario(): bool {
    return estaLogado() && isset($_SESSION['rol']) && ($_SESSION['rol'] === "usuario");
}

function esAdmin(): bool {
    return estaLogado() && isset($_SESSION['rol']) && ($_SESSION['rol'] === "administrador");
}

function esArtisto(): bool {
    return estaLogado() && isset($_SESSION['rol']) && ($_SESSION['rol'] === "artisto");
}

