<?php

// Detectar si estás en localhost o producción
$local = ($_SERVER['HTTP_HOST'] === 'localhost');

// Define la base del proyecto (ajusta si tu carpeta cambia)
define('BASE_URL', $local ? '/Exercise-Licensing/' : '/');
