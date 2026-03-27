# Sistema de rutas y BASE_URL

El proyecto usa rutas dinámicas para funcionar en cualquier
subdirectorio sin tocar el código.

## El problema

Con XAMPP el proyecto vive en un subdirectorio:
```
http://localhost/Portfolio/index.php
```

Con Docker vive en la raíz del contenedor:
```
http://localhost:8080/index.php
```

Si las rutas están hardcodeadas como `/index.php`,
funcionan en Docker pero no en XAMPP, y viceversa.

## La solución — `config/rutas.php`
```php
if (!defined('BASE_URL')) {
  $ruta_proyecto = str_replace('\\', '/', dirname(__DIR__));
  $ruta_servidor = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
  $base = str_replace($ruta_servidor, '', $ruta_proyecto);
  define('BASE_URL', rtrim($base, '/'));
}
```

Calcula automáticamente el prefijo de URL comparando
la ruta física del proyecto con la raíz del servidor.

**Con XAMPP:** `BASE_URL = /Portfolio`
**Con Docker:** `BASE_URL = ` (vacío)

## Cómo se usa

Todas las URLs internas usan `BASE_URL`:
```php
// enlaces en HTML\\
<a href="<?= BASE_URL ?>/blog.php">Blog</a>

// redirects en PHP\\
header('Location: ' . BASE_URL . '/admin/index.php');

// assets\\
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css" />
```

## Cómo se incluye

El `header.php` lo incluye automáticamente,
pero las páginas con lógica PHP antes del header
deben incluirlo ellas mismas al principio:
```php
<?php
require_once 'config/rutas.php';  // SIEMPRE PRIMERO\\
require_once 'config/db.php';     // si necesita BD\\
// ... lógica PHP ... \\
include 'includes/header.php';    // SIEMPRE AL FINAL\\
?>
```

## Orden obligatorio en cada página
```
1. require_once 'config/rutas.php'
2. require_once 'config/db.php'      (si necesita BD)
3. variables $seo_*
4. lógica PHP (POST, queries...)
5. include 'includes/header.php'
```

> Si `BASE_URL` se usa antes de incluir `rutas.php`,
> PHP lanza un error de constante no definida.