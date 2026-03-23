<?php
require_once 'config/db.php';
require_once 'config/rutas.php';
$seo_titulo = 'Blog — Víctor Suárez Dev';
$seo_descripcion = 'Artículos y notas sobre desarrollo web, PHP, JavaScript y todo lo que voy aprendiendo.';
$seo_url = 'http://localhost' . BASE_URL . '/blog.php';

$bd = conectarBD();

$por_pagina = 6;
$pagina_num = max(1, (int) ($_GET['pagina'] ?? 1));
$offset = ($pagina_num - 1) * $por_pagina;

$total_result = $bd->query("SELECT COUNT(*) as total FROM posts WHERE publicado = 1");
$total_posts = (int) $total_result->fetch_assoc()['total'];
$total_paginas = ceil($total_posts / $por_pagina);

$stmt = $bd->prepare(
  "SELECT id, titulo, slug, resumen, creado_en
   FROM posts
   WHERE publicado = 1
   ORDER BY creado_en DESC
   LIMIT ? OFFSET ?"
);
$stmt->bind_param('ii', $por_pagina, $offset);
$stmt->execute();
$posts = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$bd->close();

include 'includes/header.php';
?>

<section class="blog-hero">
  <div class="contenedor">
    <span class="etiqueta">// blog</span>
    <h1>Notas & <span class="acento">Artículos</span></h1>
    <p>Cosas que aprendo, experimentos y opiniones sobre desarrollo web.</p>
  </div>
</section>

<section class="blog-listado">
  <div class="contenedor">

    <?php if (empty($posts)): ?>
      <div class="blog-vacio">
        <span class="etiqueta">// sin resultados</span>
        <p>Aún no hay posts publicados. Vuelve pronto.</p>
      </div>

    <?php else: ?>
      <div class="blog-grid">
        <?php foreach ($posts as $i => $post):
          $tipo_post = $post['tipo'] ?? 'texto';
          ?>
          <article class="post-card <?= $i === 0 && $pagina_num === 1 ? 'post-card--destacado' : '' ?>">
            <?php if ($tipo_post === 'video' && !empty($post['miniatura'])): ?>
              <div class="post-card__media post-card__media--video">
                <img src="<?= BASE_URL . htmlspecialchars($post['miniatura']) ?>"
                  alt="<?= htmlspecialchars($post['titulo']) ?>" />
                <span class="post-card__play" aria-hidden="true">▶</span>
              </div>
            <?php elseif ($tipo_post === 'imagen' && !empty($post['imagen'])): ?>
              <div class="post-card__media">
                <img src="<?= BASE_URL . htmlspecialchars($post['imagen']) ?>"
                  alt="<?= htmlspecialchars($post['titulo']) ?>" />
              </div>
            <?php endif; ?>
            <div class="post-card__meta">
              <span class="etiqueta">
                <?= date('d M Y', strtotime($post['creado_en'])) ?>
              </span>
              <?php if ($tipo_post !== 'texto'): ?>
                <span class="post-card__tipo-badge etiqueta">
                  <?= $tipo_post === 'video' ? '▶ vídeo' : '▣ imagen' ?>
                </span>
              <?php endif; ?>
            </div>
            <h2 class="post-card__titulo">
              <a href="<?= BASE_URL ?>/post.php?slug=<?= urlencode($post['slug']) ?>">
                <?= htmlspecialchars($post['titulo']) ?>
              </a>
            </h2>
            <p class="post-card__resumen">
              <?= htmlspecialchars($post['resumen']) ?>
            </p>
            <a href="<?= BASE_URL ?>/post.php?slug=<?= urlencode($post['slug']) ?>" class="post-card__leer">
              Leer más <span aria-hidden="true">→</span>
            </a>
          </article>
        <?php endforeach; ?>
      </div>

      <!-- PAGINACIÓN -->
      <?php if ($total_paginas > 1): ?>
        <nav class="paginacion" aria-label="Páginas del blog">
          <?php if ($pagina_num > 1): ?>
            <a href="<?= BASE_URL ?>/blog.php?pagina=<?= $pagina_num - 1 ?>" class="paginacion__btn">← Anterior</a>
          <?php endif; ?>

          <div class="paginacion__numeros">
            <?php for ($p = 1; $p <= $total_paginas; $p++): ?>
              <a href="<?= BASE_URL ?>/blog.php?pagina=<?= $p ?>"
                class="paginacion__numero <?= $p === $pagina_num ? 'activo' : '' ?>">
                <?= $p ?>
              </a>
            <?php endfor; ?>
          </div>

          <?php if ($pagina_num < $total_paginas): ?>
            <a href="<?= BASE_URL ?>/blog.php?pagina=<?= $pagina_num + 1 ?>" class="paginacion__btn">Siguiente →</a>
          <?php endif; ?>
        </nav>
      <?php endif; ?>

    <?php endif; ?>

  </div>
</section>

<?php include 'includes/footer.php'; ?>