# Base de datos

## Dónde vive la BD

La base de datos está en **Clever Cloud** — un proveedor cloud
con tier gratuito real (sin tarjeta de crédito, 10MB MySQL).

Esto significa que no importa desde qué máquina trabajes:
los datos siempre son los mismos. No hay que exportar ni importar nada.
```
PC casa     →  Docker (PHP+Apache)  →  Clever Cloud MySQL
PC instituto →  Docker (PHP+Apache)  →  Clever Cloud MySQL
```

Ambos PCs comparten la misma BD. El código viaja por Git,
los datos viajan por la nube.

---

## Cómo funciona la conexión

### 1. Las credenciales viven en `.env`

El archivo `.env` está en la raíz del proyecto y **nunca se sube a Git**.
Contiene los datos de conexión que da Clever Cloud al crear el add-on:
```env
BD_HOST=xxxxxxxx.mysql.clever-cloud.com
BD_USUARIO=xxxxxxxx
BD_CONTRASENA=xxxxxxxx
BD_NOMBRE=xxxxxxxx
```

Hay un `.env.example` con la misma estructura pero sin valores reales.
Ese sí va a Git — sirve de plantilla para quien clone el proyecto.

### 2. Docker carga el `.env` automáticamente

En `docker-compose.yml` el servicio `app` tiene esta línea:
```yaml
app:
  env_file:
    - .env
```

Sin `env_file`, las variables del `.env` no llegan al contenedor PHP.
Este fue uno de los errores más comunes durante el desarrollo.

Puedes verificar que las variables llegan al contenedor:
```bash
docker exec portfolio_app printenv | grep BD_
```

### 3. PHP lee las variables con `$_ENV` o `getenv()`

En `config/db.php` las credenciales se leen así:
```php
define('BD_HOST',      $_ENV['BD_HOST']      ?? getenv('BD_HOST'));
define('BD_USUARIO',   $_ENV['BD_USUARIO']   ?? getenv('BD_USUARIO'));
define('BD_CONTRASENA',$_ENV['BD_CONTRASENA']?? getenv('BD_CONTRASENA'));
define('BD_NOMBRE',    $_ENV['BD_NOMBRE']    ?? getenv('BD_NOMBRE'));
```

`$_ENV` funciona cuando las variables vienen de Docker.
`getenv()` es el fallback por si vienen de otro sitio.
Sin valores, la conexión falla — que es el comportamiento correcto.

### 4. Se abre la conexión con MySQLi
```php
function conectarBD(): mysqli {
  $conexion = new mysqli(BD_HOST, BD_USUARIO, BD_CONTRASENA, BD_NOMBRE);

  if ($conexion->connect_error) {
    http_response_code(500);
    die('Error de conexión: ' . $conexion->connect_error);
  }

  $conexion->set_charset('utf8mb4');
  return $conexion;
}
```

Se usa en cualquier página que necesite la BD:
```php
$bd = conectarBD();
// ... queries ...
$bd->close(); // siempre cerrar al terminar
```

---

## Conexión con XAMPP (sin Docker)

Si usas XAMPP en lugar de Docker, las variables de entorno
no se cargan automáticamente desde el `.env`.

Tienes dos opciones:

**Opción A — Editar `config/db.php` directamente (solo local):**
```php
define('BD_HOST',      'xxxxxxxx.mysql.clever-cloud.com');
define('BD_USUARIO',   'xxxxxxxx');
define('BD_CONTRASENA','xxxxxxxx');
define('BD_NOMBRE',    'xxxxxxxx');
```

> No subas este archivo a Git con credenciales reales.

**Opción B — Cargar el `.env` manualmente con PHP:**

Añade esto al principio de `config/db.php`:
```php
// Cargar .env manualmente si no estamos en Docker
if (file_exists(dirname(__DIR__) . '/.env')) {
  $lineas = file(dirname(__DIR__) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  foreach ($lineas as $linea) {
    if (strpos($linea, '#') === 0) continue; // ignorar comentarios
    [$clave, $valor] = explode('=', $linea, 2);
    $_ENV[trim($clave)] = trim($valor);
  }
}
```

Esto lee el `.env` y lo carga en `$_ENV` aunque no estés en Docker.
Funciona igual en XAMPP y en Docker sin tocar nada más.

---

## Inicialización de la BD

La primera vez que levantas el proyecto necesitas crear la estructura.

**Con Docker:** se hace automáticamente.
El `schema.sql` se ejecuta al crear el contenedor MySQL gracias a:
```yaml
volumes:
  - ./schema.sql:/docker-entrypoint-initdb.d/schema.sql
```

**Con XAMPP o BD remota (Clever Cloud):**
1. Abre phpMyAdmin (`localhost/phpmyadmin` o `localhost:8081`)
2. Selecciona la BD correcta
3. Ve a la pestaña **SQL**
4. Pega el contenido de `schema.sql` y ejecuta

---

## Gestión visual con phpMyAdmin

Con Docker, phpMyAdmin está disponible en `http://localhost:8081`
y apunta directamente a Clever Cloud:
```yaml
phpmyadmin:
  environment:
    PMA_HOST: ${BD_HOST}
    PMA_USER: ${BD_USUARIO}
    PMA_PASSWORD: ${BD_CONTRASENA}
```

Desde ahí puedes ver las tablas, editar datos,
ejecutar SQL y exportar/importar sin tocar el terminal.

---

## Tabla: posts

| Campo | Tipo | Descripción |
|---|---|---|
| `id` | INT UNSIGNED, AUTO_INCREMENT | Identificador único |
| `titulo` | VARCHAR(255) | Título del post |
| `slug` | VARCHAR(255), UNIQUE | URL amigable generada desde el título |
| `resumen` | TEXT | Descripción corta para el listado |
| `contenido` | LONGTEXT | Contenido completo en HTML |
| `publicado` | TINYINT(1) | 0 = borrador, 1 = publicado |
| `tipo` | ENUM('texto','imagen','video') | Tipo de media |
| `imagen` | VARCHAR(255) | Ruta de imagen de portada |
| `video` | VARCHAR(255) | Ruta del vídeo |
| `miniatura` | VARCHAR(255) | Ruta de miniatura del vídeo |
| `creado_en` | DATETIME | Fecha de creación (automática) |
| `actualizado_en` | DATETIME | Fecha de última edición (automática) |

> Siempre se usan **prepared statements**.
> Nunca se concatena input del usuario directamente en una query.

## El slug

El slug se genera automáticamente desde el título al crear o editar un post:
```php
$slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $titulo), '-'));
```
Primero convierte el texto a minúsculas con strtolower(). Luego reemplaza cualquier carácter que no sea letra o número por guiones usando preg_replace('/[^a-zA-Z0-9]+/', '-', ...). Después elimina los guiones sobrantes al inicio y al final con trim(..., '-').

Ejemplo: `"Mi primer post en el blog"` → `"mi-primer-post-en-el-blog"`

Se usa en la URL del post: `/post.php?slug=mi-primer-post-en-el-blog`

## Consultas más usadas

**Listar posts publicados con paginación:**

```php
$stmt = $bd->prepare(
  "SELECT id, titulo, slug, resumen, creado_en
   FROM posts
   WHERE publicado = 1
   ORDER BY creado_en DESC
   LIMIT ? OFFSET ?"
);
$stmt->bind_param('ii', $por_pagina, $offset);
```

**Buscar un post por slug:**

```php
$stmt = $bd->prepare(
  "SELECT * FROM posts WHERE slug = ? AND publicado = 1"
);
$stmt->bind_param('s', $slug);
```

> Siempre se usan **prepared statements** para evitar SQL injection.
> Nunca se concatena directamente input del usuario en una query.

## Inicialización

Al levantar Docker por primera vez, el archivo `schema.sql`
se ejecuta automáticamente gracias a esta línea del `docker-compose.yml`:

```yaml
volumes:
  - ./schema.sql:/docker-entrypoint-initdb.d/schema.sql
```

Esto crea la tabla y añade un post de ejemplo.
