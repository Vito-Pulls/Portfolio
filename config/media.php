<?php
// Configuración de subida de archivos\\
define('UPLOAD_DIR', dirname(__DIR__) . '/assets/uploads/');
define('UPLOAD_URL', '/assets/uploads/');

// Imágenes\\
define('IMG_MAX_SIZE', 5 * 1024 * 1024);  // 5MB
define('IMG_TIPOS', ['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
define('IMG_EXTENSIONES', ['jpg', 'jpeg', 'png', 'webp', 'gif']);

// Vídeos\\
define('VIDEO_MAX_SIZE', 10 * 1024 * 1024); // 10MB
define('VIDEO_TIPOS', ['video/mp4', 'video/webm', 'video/ogg']);
define('VIDEO_EXTENSIONES', ['mp4', 'webm', 'ogg']);

/**
 * Sube un archivo al servidor y devuelve la ruta relativa o null si falla.
 * $campo     — nombre del campo en $_FILES
 * $tipo      — 'imagen' o 'video'
 * $error_ref — variable por referencia para recibir el mensaje de error
 */
function subirArchivo(string $campo, string $tipo, string &$error_ref): ?string
{
    if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    $archivo = $_FILES[$campo];

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        $error_ref = 'Error al subir el archivo.';
        return null;
    }

    $tam_max = $tipo === 'video' ? VIDEO_MAX_SIZE : IMG_MAX_SIZE;
    $tipos_ok = $tipo === 'video' ? VIDEO_TIPOS : IMG_TIPOS;
    $exts_ok = $tipo === 'video' ? VIDEO_EXTENSIONES : IMG_EXTENSIONES;

    // Validar tamaño\\
    if ($archivo['size'] > $tam_max) {
        $mb = $tam_max / 1024 / 1024;
        $error_ref = "El archivo supera el límite de {$mb}MB.";
        return null;
    }

    // Validar tipo MIME real\\
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_real = $finfo->file($archivo['tmp_name']);

    if (!in_array($mime_real, $tipos_ok)) {
        $error_ref = 'Tipo de archivo no permitido.';
        return null;
    }

    // Validar extensión\\
    $ext = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $exts_ok)) {
        $error_ref = 'Extensión no permitida.';
        return null;
    }

    // Nombre único para evitar colisiones\\
    $nombre_final = uniqid('media_', true) . '.' . $ext;
    $ruta_destino = UPLOAD_DIR . $nombre_final;

    if (!move_uploaded_file($archivo['tmp_name'], $ruta_destino)) {
        $error_ref = 'No se pudo mover el archivo al servidor.';
        return null;
    }

    return UPLOAD_URL . $nombre_final;
}

/**
 * Elimina un archivo de uploads si existe.
 */
function eliminarArchivo(?string $ruta): void
{
    if (empty($ruta))
        return;
    $ruta_fisica = dirname(__DIR__) . $ruta;
    if (file_exists($ruta_fisica)) {
        unlink($ruta_fisica);
    }
}