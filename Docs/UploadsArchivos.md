# Subida de archivos

La subida de archivos se gestiona en `config/media.php`.

## Dónde se guardan

Los archivos se guardan en `assets/uploads/`.
Esta carpeta está en `.gitignore` — los archivos no se suben a Git.
Solo se sube el `.gitkeep` para que la carpeta exista en el repo.

## Límites

| Tipo | Tamaño máximo | Formatos permitidos |
|---|---|---|
| Imagen | 5MB | JPG, PNG, WEBP, GIF |
| Vídeo | 10MB | MP4, WEBM, OGG |

Estos límites también están configurados en `docker/php.ini`:
```ini
upload_max_filesize = 15M
post_max_size = 20M
```

## Cómo funciona `subirArchivo()`
```php
function subirArchivo(string $campo, string $tipo, string &$error_ref): ?string
```

1. Comprueba que se ha subido un archivo
2. Valida el tamaño
3. Valida el tipo MIME real con `finfo` (no solo la extensión)
4. Valida la extensión
5. Genera un nombre único con `uniqid()`
6. Mueve el archivo a `assets/uploads/`
7. Devuelve la ruta relativa o `null` si hay error
```php
$nombre_final = uniqid('media_', true) . '.' . $ext;
$ruta_destino = UPLOAD_DIR . $nombre_final;
move_uploaded_file($archivo['tmp_name'], $ruta_destino);
```

## Por qué se valida el MIME real

La extensión del archivo se puede falsificar fácilmente.
Un atacante podría subir un archivo `.php` renombrado como `.jpg`.
Por eso se usa `finfo` para leer el tipo real del archivo:
```php
$finfo     = new finfo(FILEINFO_MIME_TYPE);
$mime_real = $finfo->file($archivo['tmp_name']);
```

## Eliminar archivos

Cuando se edita o borra un post, los archivos viejos
se eliminan del servidor con `eliminarArchivo()`:
```php
function eliminarArchivo(?string $ruta): void {
  $ruta_fisica = dirname(__DIR__) . $ruta;
  if (file_exists($ruta_fisica)) {
    unlink($ruta_fisica);
  }
}
```