<?php
define('BD_HOST',      'localhost');
define('BD_USUARIO',   'root');
define('BD_CONTRASENA', '');
define('BD_NOMBRE',    'portfolio');
define('BD_CHARSET',   'utf8mb4');

function conectarBD(): mysqli {
  $conexion = new mysqli(BD_HOST, BD_USUARIO, BD_CONTRASENA, BD_NOMBRE);

  if ($conexion->connect_error) {
    http_response_code(500);
    die(json_encode(['error' => 'Error de conexión a la base de datos.']));
  }

  $conexion->set_charset(BD_CHARSET);
  return $conexion;
}