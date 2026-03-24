<?php
// Lee credenciales desde variables de entorno \\
// Si no existen, usa valores locales como fallback \\
define('BD_HOST', $_ENV['BD_HOST'] ?? getenv('BD_HOST'));
define('BD_USUARIO', $_ENV['BD_USUARIO'] ?? getenv('BD_USUARIO'));
define('BD_CONTRASENA', $_ENV['BD_CONTRASENA'] ?? getenv('BD_CONTRASENA'));
define('BD_NOMBRE', $_ENV['BD_NOMBRE'] ?? getenv('BD_NOMBRE'));
define('BD_CHARSET', 'utf8mb4');

function conectarBD(): mysqli
{
  $conexion = new mysqli(BD_HOST, BD_USUARIO, BD_CONTRASENA, BD_NOMBRE);

  if ($conexion->connect_error) {
    http_response_code(500);
    die('Error de conexión: ' . $conexion->connect_error);
  }

  $conexion->set_charset(BD_CHARSET);
  return $conexion;
}