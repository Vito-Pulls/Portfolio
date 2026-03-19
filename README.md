# Portfolio — Víctor Javier Suárez Acosta

Portfolio personal y blog desarrollado con PHP, HTML, CSS y JavaScript vanilla.

## Stack

- **Frontend:** HTML5, CSS3 (custom properties, grid, flexbox), JavaScript vanilla
- **Backend:** PHP 8.2
- **Base de datos:** MySQL (via MySQLi)
- **Entorno local:** XAMPP / Laragon

## Estructura del proyecto

```
Portfolio/
├── admin/              # Panel de administración (protegido por sesión)
│   ├── index.php
│   ├── login.php
│   ├── logout.php
│   ├── newPost.php
│   ├── editPost.php
│   └── admin.css
├── assets/
│   ├── css/style.css
│   ├── js/main.js
│   └── img/
├── config/
│   ├── db.php          # Conexión a base de datos
│   └── rutas.php       # Define BASE_URL dinámicamente
├── includes/
│   ├── header.php
│   └── footer.php
├── index.php           # Home — hero + proyectos
├── about.php           # Sobre mí + skills
├── blog.php            # Listado de posts con paginación
├── post.php            # Vista individual de post
├── contacto.php        # Formulario de contacto
└── schema.sql          # Schema y datos de ejemplo
```

## Instalación local

1. Clona o copia la carpeta en `htdocs`:

```bash
   C:\xampp\htdocs\Portfolio\
```

2. Importa la base de datos:
   - Abre `phpMyAdmin` → `localhost/phpmyadmin`
   - Importa el archivo `schema.sql`

3. Configura las credenciales en `config/db.php`:

```php
   define('BD_USUARIO',    'root');
   define('BD_CONTRASENA', '');
   define('BD_NOMBRE',     'portfolio');
```

4. Accede en el navegador:

```
   http://localhost/Portfolio/
```

## Acceso al panel admin

```
URL:        http://localhost/Portfolio/admin/login.php
Usuario:    victor
Contraseña: admin1234
```

> ⚠️ Cambia las credenciales antes de subir a producción.

## Ramas del proyecto

| Rama                     | Descripción                     |
| ------------------------ | ------------------------------- |
| `main`                   | Código estable                  |
| `feature/blog-database`  | BD, schema y panel admin        |
| `feature/blog-frontend`  | Blog público y vista de post    |
| `feature/seo-responsive` | SEO, responsive y documentación |

## Autor

**Víctor Javier Suárez Acosta**
Desarrollador Web Junior — Fullstack PHP + JS
