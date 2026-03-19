<?php
if (!defined('BASE_URL')) {
    // __DIR__ = C:/xampp/htdocs/Portfolio/config
    // dirname(__DIR__) = C:/xampp/htdocs/Portfolio 
    // $_SERVER['DOCUMENT_ROOT'] = C:/xampp/htdocs

    $ruta_proyecto = str_replace('\\', '/', dirname(__DIR__));
    $ruta_servidor = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));

    $base = str_replace($ruta_servidor, '', $ruta_proyecto);

    define('BASE_URL', rtrim($base, '/'));
}