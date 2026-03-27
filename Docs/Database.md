# Base de datos

La base de datos está en **Clever Cloud** (MySQL 8.0, tier gratuito).
En local se puede usar el contenedor MySQL del docker-compose o importando schema.sql en PHPMyAdmin.

## Conexión

La conexión se gestiona en `config/db.php`.
Las credenciales vienen de variables de entorno definidas en `.env`:
```env
BD_HOST=xxxx.mysql.clever-cloud.com
BD_USUARIO=xxxx
BD_CONTRASENA=xxxx
BD_NOMBRE=xxxx
```

La función `conectarBD()` devuelve una conexión MySQLi lista para usar:
```php
$bd = conectarBD();
$resultado = $bd->query("SELECT * FROM posts");
```

## Tabla: posts

Es la única tabla del proyecto por ahora. Almacena los posts del blog.

| Campo | Tipo | Descripción |
|---|---|---|
| `id` | INT UNSIGNED, AUTO_INCREMENT | Identificador único |
| `titulo` | VARCHAR(255) | Título del post |
| `slug` | VARCHAR(255), UNIQUE | URL amigable generada desde el título |
| `resumen` | TEXT | Descripción corta, se muestra en el listado |
| `contenido` | LONGTEXT | Contenido completo en HTML |
| `publicado` | TINYINT(1) | 0 = borrador, 1 = publicado |
| `tipo` | ENUM('texto','imagen','video') | Tipo de media del post |
| `imagen` | VARCHAR(255) | Ruta de la imagen de portada |
| `video` | VARCHAR(255) | Ruta del vídeo |
| `miniatura` | VARCHAR(255) | Ruta de la miniatura del vídeo |
| `creado_en` | DATETIME | Fecha de creación (automática) |
| `actualizado_en` | DATETIME | Fecha de última edición (automática) |

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