<?php

$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : 'error';

if ($nombre == 'error') {
    header("Location: index.html");
}

echo "Hola, $nombre!";
