# Autenticación del Admin

El panel de administración está protegido por un sistema de login
con sesiones PHP. No hay registro de usuarios — solo existe
una cuenta de administrador definida en las variables de entorno.

## Flujo de login

1. El usuario accede a `/admin/login.php`
2. Introduce usuario y contraseña
3. PHP compara con las variables de entorno `ADMIN_USUARIO` y `ADMIN_CONTRASENA`
4. Si son correctas, se crea la sesión y redirige a `/admin/index.php`
5. Si no, se muestra un mensaje de error
```php
$usuario_valido    = $_ENV['ADMIN_USUARIO']    ?? getenv('ADMIN_USUARIO');
$contrasena_valida = $_ENV['ADMIN_CONTRASENA'] ?? getenv('ADMIN_CONTRASENA');

if ($usuario === $usuario_valido && $contrasena === $contrasena_valida) {
  $_SESSION['admin_logueado'] = true;
  header('Location: ' . BASE_URL . '/admin/index.php');
  exit;
}
```

## Protección de páginas del admin

Cada página del admin comprueba si existe la sesión al inicio.
Si no existe, redirige al login:
```php
session_start();

if (!isset($_SESSION['admin_logueado'])) {
  header('Location: ' . BASE_URL . '/admin/login.php');
  exit;
}
```

## Cerrar sesión

`/admin/logout.php` destruye la sesión y redirige al login:
```php
session_start();
session_destroy();
header('Location: ' . BASE_URL . '/admin/login.php');
exit;
```

## Variables de entorno

Las credenciales nunca están en el código.
Se definen en el archivo `.env` (que no se sube a Git):
```env
ADMIN_USUARIO=nombre_usuario
ADMIN_CONTRASENA=tu_contrasena_segura
```

> Si las variables de entorno no están definidas,
> el login devuelve error y no permite el acceso.
> Esto obliga a tener el `.env` bien configurado.

