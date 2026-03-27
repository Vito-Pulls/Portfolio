# CRUD del Blog

Las operaciones de crear, leer, editar y borrar posts
se gestionan desde el panel de administración en `/admin/`.

## Crear un post — `newPost.php`

1. El admin rellena el formulario con título, resumen, contenido y tipo
2. Se validan los campos obligatorios
3. Si hay archivo (imagen o vídeo), se sube con `subirArchivo()`
4. Se genera el slug desde el título
5. Se inserta en la BD con prepared statement
```php
$stmt = $bd->prepare(
  "INSERT INTO posts (titulo, slug, resumen, contenido, publicado, tipo, imagen, video, miniatura)
   VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param('ssssissss', ...);
```

## Tipos de post

Cada post tiene un tipo que determina qué media muestra:

| Tipo | Media |
|---|---|
| `texto` | Solo texto, sin media |
| `imagen` | Imagen de portada |
| `video` | Vídeo + miniatura opcional |

El tipo se selecciona visualmente en el admin con un selector de radio buttons.
Los campos de subida aparecen y desaparecen con JavaScript según el tipo elegido.

## Leer posts — `blog.php` y `post.php`

**Listado (`blog.php`):** muestra solo los posts con `publicado = 1`,
ordenados por fecha descendente, con paginación de 6 por página.

**Post individual (`post.php`):** busca por slug en la URL.
Si el post no existe o no está publicado, redirige al blog.
También carga el post anterior y siguiente para la navegación.

## Editar un post — `editPost.php`

Carga los datos actuales del post en el formulario.
Si se sube un archivo nuevo, reemplaza el anterior y borra el fichero viejo del servidor.
Si se cambia el tipo de post, limpia los archivos del tipo anterior.
```php
// Solo reemplaza si se sube archivo nuevo
if (!empty($_FILES['imagen']['name'])) {
  eliminarArchivo($ruta_imagen_anterior);
  $ruta_imagen = subirArchivo('imagen', 'imagen', $error);
}
```

## Borrar un post — `index.php` del admin

Se borra por ID desde un enlace con confirmación JavaScript:
```php
if (isset($_GET['eliminar'])) {
  $id = (int) $_GET['eliminar'];
  $bd->query("DELETE FROM posts WHERE id = $id");
}
```

## Validaciones

Todos los campos obligatorios se validan en el servidor.
Los errores se muestran campo a campo en el formulario.
El input del usuario siempre pasa por `htmlspecialchars()` antes de mostrarse.