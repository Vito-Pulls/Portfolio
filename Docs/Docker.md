# Docker

El proyecto corre en contenedores Docker.
Esto garantiza que el entorno es idéntico en cualquier máquina.

## Servicios
```yaml
app          # PHP 8.2 + Apache — la aplicación
phpmyadmin   # Interfaz visual para gestionar la BD
```

El contenedor MySQL local se eliminó cuando se migró la BD a Clever Cloud.

## Arrancar el proyecto
```bash
docker compose up -d --build
```

- `up` — levanta los contenedores
- `-d` — en segundo plano (detached)
- `--build` — reconstruye la imagen si hay cambios en el Dockerfile

## URLs

| Servicio | URL |
|---|---|
| Portfolio | http://localhost:8080 |
| phpMyAdmin | http://localhost:8081 |
| Admin | http://localhost:8080/admin/login.php |

## Parar los contenedores
```bash
docker compose down        # para y elimina contenedores, conserva datos
docker compose down -v     # para, elimina contenedores Y datos
```

## Variables de entorno

Las credenciales se definen en `.env` (no va a Git).
Hay un `.env.example` con la estructura sin valores reales.
```env
BD_HOST=xxxx.mysql.clever-cloud.com
BD_USUARIO=xxxx
BD_CONTRASENA=xxxx
BD_NOMBRE=xxxx
ADMIN_USUARIO=xxxx
ADMIN_CONTRASENA=xxxx
```

Docker carga el `.env` gracias a `env_file` en el `docker-compose.yml`:
```yaml
app:
  env_file:
    - .env
```

Sin `env_file`, las variables no llegan al contenedor PHP.

## Base de datos en la nube — Clever Cloud

La BD está en Clever Cloud (tier gratuito, 10MB MySQL).
Esto permite trabajar desde cualquier máquina con los mismos datos
sin exportar/importar tablas manualmente.

**Ventajas:**
- Mismos datos en todos los equipos
- Sin pérdida de información entre sesiones
- Gratuito para proyectos pequeños

**Cómo conectar phpMyAdmin a Clever Cloud:**
```yaml
phpmyadmin:
  environment:
    PMA_HOST: ${BD_HOST}
    PMA_PORT: 3306
    PMA_USER: ${BD_USUARIO}
    PMA_PASSWORD: ${BD_CONTRASENA}
```

## Configuración de PHP

`docker/php.ini` sobreescribe los límites por defecto de PHP:
```ini
upload_max_filesize = 15M
post_max_size = 20M
max_execution_time = 60
memory_limit = 128M
```

## Dockerfile
```dockerfile
FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html/
```