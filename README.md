# Portfolio — Víctor Javier Suárez Acosta

Portfolio personal y blog desarrollado con PHP, HTML, CSS y JavaScript vanilla.

## Stack

- **Frontend:** HTML5, CSS3 (custom properties, grid, flexbox), JavaScript vanilla
- **Backend:** PHP 8.2
- **Base de datos:** MySQL (via MySQLi)
- **Entorno local:** XAMPP / DOCKER

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
│   ├── img/
|   └── uploads/
├── config/
│   ├── db.php          # Conexión a base de datos
│   ├── rutas.php       # Define BASE_URL dinámicamente
|   └── media.php     
├── includes/
│   ├── header.php
│   └── footer.php
├── docker/
│   └── apache.conf
├── index.php           # Home — hero + proyectos
├── about.php           # Sobre mí + skills
├── blog.php          # Listado de posts con paginación
├── post.php            # Vista individual de post
├── contacto.php        # Formulario de contacto
├── schema.sql          # Schema y datos de ejemplo
├── Dockerfile
├── docker-compose.yml
└── .env                # Variables de entorno
```

## Instalación local

### Con Docker (recomendado)

**Requisitos:** Docker + Docker Compose

```bash
# 1. Clona el repositorio
git clone https://github.com/Vito-Pulls/Portfolio.git
cd Portfolio

# 2. Copia las variables de entorno
cp .env.example .env
# Edita .env con tus credenciales si quieres cambiarlas

# 3. Levanta los contenedores
docker compose up -d --build

# 4. Accede a la app
# Portfolio:   http://localhost:8080
# phpMyAdmin:  http://localhost:8081
# Admin panel: http://localhost:8080/admin/login.php
```

Para parar los contenedores:

```bash
docker compose down
```

Para parar y borrar los datos de la BD:

```bash
docker compose down -v
```

### Sin Docker (XAMPP / Laragon)

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
URL: (XAMPP)        http://localhost/Portfolio/admin/login.php
URL: (DOCKER)        http://localhost:8080/admin/login.php
Usuario:    victor
Contraseña: 1959
```

> Cambia las credenciales antes de subir a producción.

## Autor

**Víctor Javier Suárez Acosta**
Desarrollador Web Junior — Fullstack PHP + JS
