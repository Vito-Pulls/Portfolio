<?php
$pagina_actual = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Víctor Suárez — Dev</title>
  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<header class="site-header">
  <div class="contenedor nav">
    <a href="/index.php" class="nav__logo">
      <span class="nav__logo-corchete">[</span>VS<span class="acento">.</span>dev<span class="nav__logo-corchete">]</span>
    </a>

    <button class="nav__toggle" id="navToggle" aria-label="Abrir menú">
      <span></span><span></span><span></span>
    </button>

    <ul class="nav__enlaces" id="navEnlaces">
      <li><a href="/index.php"   class="<?= $pagina_actual === 'index.php'   ? 'activo' : '' ?>">inicio</a></li>
      <li><a href="/about.php"   class="<?= $pagina_actual === 'about.php'   ? 'activo' : '' ?>">sobre_mi</a></li>
      <li><a href="/blog.php"    class="<?= $pagina_actual === 'blog.php'    ? 'activo' : '' ?>">blog</a></li>
      <li><a href="/contacto.php" class="<?= $pagina_actual === 'contacto.php' ? 'activo' : '' ?>">contacto</a></li>
    </ul>
  </div>
</header>

<main class="contenido-principal">