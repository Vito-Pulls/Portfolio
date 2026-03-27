# Despliegue del proyecto

El proyecto está diseñado para funcionar en dos entornos
con cambios mínimos entre ellos.
```
XAMPP  →  cambia poco, ideal para empezar rápido
Docker →  el que uso, entorno reproducible
```

---

## Opción A — XAMPP

### 1. Clonar el proyecto
```bash
cd C:/xampp/htdocs
git clone https://github.com/Vito-Pulls/Portfolio.git
```

El proyecto queda en `C:/xampp/htdocs/Portfolio/`.

### 2. Configurar las credenciales

Copia `.env.example` a `.env`:
```bash
cp .env.example .env
```

Edita `.env` con tus credenciales de Clever Cloud:
```env
BD_HOST=xxxxxxxx.mysql.clever-cloud.com
BD_USUARIO=xxxxxxxx
BD_CONTRASENA=xxxxxxxx
BD_NOMBRE=xxxxxxxx
ADMIN_USUARIO=nombre_admin
ADMIN_CONTRASENA=tu_contrasena
```

Para que XAMPP lea el `.env`, añade el lector manual
al principio de `config/db.php` (ver documento Database.md).

### 3. Inicializar la BD

Abre `http://localhost/phpmyadmin`:
- Selecciona la BD de Clever Cloud (o crea una local)
- Pestaña SQL → pega `schema.sql` → ejecuta

### 4. Acceder al proyecto
```
http://localhost/Portfolio/
http://localhost/Portfolio/admin/login.php
```

### Diferencia de BASE_URL con XAMPP

Con XAMPP el proyecto vive en un subdirectorio:
```
BASE_URL = /Portfolio
```

El sistema de rutas lo calcula automáticamente.
No hay que cambiar nada en el código.

---

## Opción B — Docker

### 1. Instalar Docker
```bash
# Verificar que está instalado
docker --version
docker compose version
```

Si no está instalado, descarga Docker Engine desde
[docs.docker.com/engine/install](https://docs.docker.com/engine/install/).

### 2. Clonar el proyecto
```bash
git clone https://github.com/Vito-Pulls/Portfolio.git
cd Portfolio
```

### 3. Configurar las credenciales
```bash
cp .env.example .env
```

Edita `.env`:
```env
BD_HOST=xxxxxxxx.mysql.clever-cloud.com
BD_USUARIO=xxxxxxxx
BD_CONTRASENA=xxxxxxxx
BD_NOMBRE=xxxxxxxx
ADMIN_USUARIO=admin_usuario
ADMIN_CONTRASENA=tu_contrasena
```

### 4. Levantar los contenedores
```bash
docker compose up -d --build
```

### 5. Inicializar la BD

Solo hace falta la primera vez.
Abre `http://localhost:8081` (phpMyAdmin):
- Ya está conectado a Clever Cloud
- Pestaña SQL → pega `schema.sql` → ejecuta

### 6. Acceder al proyecto
```
http://localhost:8080/                    → portfolio
http://localhost:8081/                    → phpMyAdmin
http://localhost:8080/admin/login.php     → panel admin
```

### Diferencia de BASE_URL con Docker

Con Docker el proyecto vive en la raíz del contenedor:
```
BASE_URL = (vacío)
```

El sistema de rutas lo calcula automáticamente.
No hay que cambiar nada en el código.

---

## Comparativa XAMPP vs Docker

| | XAMPP | Docker |
|---|---|---|
| Arrancar | Abrir panel XAMPP + start | `docker compose up -d` |
| Parar | Stop en el panel | `docker compose down` |
| URL | `localhost/Portfolio` | `localhost:8080` |
| BASE_URL | `/Portfolio` | `` (vacío) |
| PHP version | La del instalador | 8.2 (fija en Dockerfile) |
| Conflictos de puerto | Posibles (3306, 80) | No — puertos mapeados |
| BD | Clever Cloud (remoto) | Clever Cloud (remoto) |
| phpMyAdmin | `localhost/phpmyadmin` | `localhost:8081` |
| Reproducible | depende del PC | siempre igual |

---

## Cambiar de XAMPP a Docker (o viceversa)

Como la BD está en Clever Cloud, los datos son los mismos
en cualquier entorno. Solo cambia cómo se levanta el servidor PHP.

**De XAMPP a Docker:**
1. Para XAMPP
2. `docker compose up -d --build`
3. Accede en `localhost:8080`

**De Docker a XAMPP:**
1. `docker compose down`
2. Abre XAMPP y arranca Apache
3. Accede en `localhost/Portfolio`

No hay migración de datos — la BD siempre es la misma.

---

## Comandos útiles de Docker
```bash
# Levantar contenedores
docker compose up -d

# Levantar y reconstruir imagen (tras cambios en Dockerfile)
docker compose up -d --build

# Ver logs en tiempo real
docker compose logs -f app

# Ver logs solo de errores PHP/Apache
docker exec portfolio_app tail -f /var/log/apache2/error.log

# Entrar al contenedor
docker exec -it portfolio_app bash

# Ver variables de entorno cargadas
docker exec portfolio_app printenv | grep BD_

# Parar contenedores (conserva datos)
docker compose down

# Parar y eliminar volúmenes (borra uploads locales)
docker compose down -v

# Ver estado de los contenedores
docker compose ps
```