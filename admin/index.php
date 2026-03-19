<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['admin_logueado'])) {
  header('Location: login.php');
  exit;
}

$bd = conectarBD();

// Eliminar post
if (isset($_GET['eliminar'])) {
  $id = (int) $_GET['eliminar'];
  $bd->query("DELETE FROM posts WHERE id = $id");
  header('Location: index.php?ok=eliminado');
  exit;
}

// Obtener todos los posts
$resultado = $bd->query("SELECT id, titulo, publicado, creado_en FROM posts ORDER BY creado_en DESC");
$posts     = $resultado->fetch_all(MYSQLI_ASSOC);
$bd->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin — Posts</title>
  <link rel="stylesheet" href="../assets/css/style.css" />
  <link rel="stylesheet" href="admin.css" />
</head>
<body class="admin-body">

<header class="admin-header">
  <span class="admin-header__logo">[VS<span class="acento">.</span>admin]</span>
  <nav class="admin-header__nav">
    <a href="nuevo-post.php" class="btn btn--primario">+ Nuevo post</a>
    <a href="logout.php" class="admin-header__salir">Salir</a>
  </nav>
</header>

<main class="admin-main contenedor">
  <div class="seccion-header">
    <span class="etiqueta">// gestión</span>
    <h2>Posts del blog<span class="acento">.</span></h2>
  </div>

  <?php if (isset($_GET['ok'])): ?>
    <div class="contact-alert contact-alert--ok" style="margin-bottom:1.5rem">
      ✓ Post <?= $_GET['ok'] === 'eliminado' ? 'eliminado' : 'guardado' ?> correctamente.
    </div>
  <?php endif; ?>

  <table class="admin-tabla">
    <thead>
      <tr>
        <th>Título</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($posts)): ?>
        <tr>
          <td colspan="4" class="admin-tabla__vacio">No hay posts todavía.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($posts as $post): ?>
          <tr>
            <td class="admin-tabla__titulo"><?= htmlspecialchars($post['titulo']) ?></td>
            <td>
              <span class="admin-badge <?= $post['publicado'] ? 'admin-badge--publicado' : 'admin-badge--borrador' ?>">
                <?= $post['publicado'] ? 'Publicado' : 'Borrador' ?>
              </span>
            </td>
            <td class="admin-tabla__fecha">
              <?= date('d/m/Y', strtotime($post['creado_en'])) ?>
            </td>
            <td class="admin-tabla__acciones">
              <a href="editar-post.php?id=<?= $post['id'] ?>" class="admin-enlace">Editar</a>
              <a href="index.php?eliminar=<?= $post['id'] ?>"
                 class="admin-enlace admin-enlace--peligro"
                 onclick="return confirm('¿Eliminar este post?')">Eliminar</a>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</main>

</body>
</html>