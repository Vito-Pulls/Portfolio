<?php
require_once 'config/db.php';
require_once 'config/rutas.php';

$bd = conectarBD();
$slug = trim($_GET['slug'] ?? '');

if (empty($slug)) {
  header('Location: ' . BASE_URL . '/blog.php');
  exit;
}

$stmt = $bd->prepare(
  "SELECT * FROM posts WHERE slug = ? AND publicado = 1"
);
$stmt->bind_param('s', $slug);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

$stmt_prev = $bd->prepare(
  "SELECT titulo, slug FROM posts
   WHERE publicado = 1 AND creado_en < ?
   ORDER BY creado_en DESC LIMIT 1"
);
$stmt_prev->bind_param('s', $post['creado_en']);
$stmt_prev->execute();
$post_anterior = $stmt_prev->get_result()->fetch_assoc();
$stmt_prev->close();

$stmt_next = $bd->prepare(
  "SELECT titulo, slug FROM posts
   WHERE publicado = 1 AND creado_en > ?
   ORDER BY creado_en ASC LIMIT 1"
);
$stmt_next->bind_param('s', $post['creado_en']);
$stmt_next->execute();
$post_siguiente = $stmt_next->get_result()->fetch_assoc();
$stmt_next->close();

$bd->close();

if (!$post) {
  header('Location: ' . BASE_URL . '/blog.php');
  exit;
}

include 'includes/header.php';
?>

<section class="post-header">
  <div class="contenedor post-header__contenido">
    <a href="<?= BASE_URL ?>/blog.php" class="post-header__volver">
      ← Volver al blog
    </a>
    <div class="post-header__meta">
      <span class="etiqueta">
        <?= date('d M Y', strtotime($post['creado_en'])) ?>
      </span>
      <?php if ($post['actualizado_en'] !== $post['creado_en']): ?>
        <span class="etiqueta" style="color: var(--color-texto-tenue)">
          · actualizado <?= date('d M Y', strtotime($post['actualizado_en'])) ?>
        </span>
      <?php endif; ?>
    </div>
    <h1 class="post-header__titulo">
      <?= htmlspecialchars($post['titulo']) ?>
    </h1>
    <p class="post-header__resumen">
      <?= htmlspecialchars($post['resumen']) ?>
    </p>
  </div>
</section>

<article class="post-articulo">
  <div class="contenedor post-articulo__grid">

    <div class="post-cuerpo">
      <?= $post['contenido'] ?>
    </div>

    <!-- SIDEBAR -->
    <aside class="post-sidebar">
      <div class="post-sidebar__bloque">
        <span class="etiqueta">// fecha</span>
        <p><?= date('d \d\e F \d\e Y', strtotime($post['creado_en'])) ?></p>
      </div>
      <div class="post-sidebar__bloque">
        <span class="etiqueta">// compartir</span>
        <div class="post-sidebar__compartir">
          <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['titulo']) ?>&url=<?= urlencode('http://localhost' . BASE_URL . '/post.php?slug=' . $post['slug']) ?>"
            target="_blank" rel="noopener" class="post-sidebar__red">
            Twitter / X
          </a>
          <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode('http://localhost' . BASE_URL . '/post.php?slug=' . $post['slug']) ?>"
            target="_blank" rel="noopener" class="post-sidebar__red">
            LinkedIn
          </a>
        </div>
      </div>
    </aside>

  </div>
</article>

<nav class="post-nav">
  <div class="contenedor post-nav__grid">
    <div class="post-nav__anterior">
      <?php if ($post_anterior): ?>
        <span class="etiqueta">← anterior</span>
        <a href="<?= BASE_URL ?>/post.php?slug=<?= urlencode($post_anterior['slug']) ?>" class="post-nav__titulo">
          <?= htmlspecialchars($post_anterior['titulo']) ?>
        </a>
      <?php endif; ?>
    </div>
    <div class="post-nav__siguiente">
      <?php if ($post_siguiente): ?>
        <span class="etiqueta">siguiente →</span>
        <a href="<?= BASE_URL ?>/post.php?slug=<?= urlencode($post_siguiente['slug']) ?>" class="post-nav__titulo">
          <?= htmlspecialchars($post_siguiente['titulo']) ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<?php include 'includes/footer.php'; ?>