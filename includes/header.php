<?php
require_once $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['SCRIPT_NAME']) . '/config/rutas.php';
$pagina_actual = basename($_SERVER['PHP_SELF']);

// SEO — cada página puede sobreescribir estas variables antes del include
$seo_titulo = $seo_titulo ?? 'Víctor Suárez — Desarrollador Web';
$seo_descripcion = $seo_descripcion ?? 'Portfolio y blog de Víctor Javier Suárez Acosta, desarrollador web fullstack con foco en PHP y JavaScript.';
$seo_url = $seo_url ?? 'http://localhost' . BASE_URL . '/' . $pagina_actual;
$seo_imagen = $seo_imagen ?? 'http://localhost' . BASE_URL . '/assets/img/og-default.png';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title><?= htmlspecialchars($seo_titulo) ?></title>
  <meta name="description" content="<?= htmlspecialchars($seo_descripcion) ?>" />
  <meta name="author" content="Víctor Javier Suárez Acosta" />
  <link rel="canonical" href="<?= htmlspecialchars($seo_url) ?>" />

  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?= htmlspecialchars($seo_titulo) ?>" />
  <meta property="og:description" content="<?= htmlspecialchars($seo_descripcion) ?>" />
  <meta property="og:url" content="<?= htmlspecialchars($seo_url) ?>" />
  <meta property="og:image" content="<?= htmlspecialchars($seo_imagen) ?>" />
  <meta property="og:locale" content="es_ES" />
  <meta property="og:site_name" content="Víctor Suárez Dev" />

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="<?= htmlspecialchars($seo_titulo) ?>" />
  <meta name="twitter:description" content="<?= htmlspecialchars($seo_descripcion) ?>" />
  <meta name="twitter:image" content="<?= htmlspecialchars($seo_imagen) ?>" />

  <link rel="icon" type="image/png" href="<?= BASE_URL ?>/assets/img/favicon.png" />

  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css" />
</head>

<body>

  <header class="site-header">
    <div class="contenedor nav">
      <a href="<?= BASE_URL ?>/index.php" class="nav__logo">
        <span class="nav__logo-corchete">[</span>VS<span class="acento">.</span>dev<span
          class="nav__logo-corchete">]</span>
      </a>

      <button class="nav__toggle" id="navToggle" aria-label="Abrir menú">
        <span></span><span></span><span></span>
      </button>

      <ul class="nav__enlaces" id="navEnlaces">
        <li><a href="<?= BASE_URL ?>/index.php"
            class="<?= $pagina_actual === 'index.php' ? 'activo' : '' ?>">inicio</a></li>
        <li><a href="<?= BASE_URL ?>/about.php"
            class="<?= $pagina_actual === 'about.php' ? 'activo' : '' ?>">sobre_mi</a></li>
        <li><a href="<?= BASE_URL ?>/blog.php" class="<?= $pagina_actual === 'blog.php' ? 'activo' : '' ?>">blog</a>
        </li>
        <li><a href="<?= BASE_URL ?>/contacto.php"
            class="<?= $pagina_actual === 'contacto.php' ? 'activo' : '' ?>">contacto</a></li>
      </ul>
    </div>
  </header>

  <main class="contenido-principal">