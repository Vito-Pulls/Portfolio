<?php
require_once '../config/db.php';
require_once '../config/rutas.php';
session_start();

if (!isset($_SESSION['admin_logueado'])) {
    header('Location: ' . BASE_URL . '/admin/login.php');
    exit;
}

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $resumen = trim($_POST['resumen'] ?? '');
    $contenido = trim($_POST['contenido'] ?? '');
    $publicado = isset($_POST['publicado']) ? 1 : 0;
    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $titulo), '-'));

    if (empty($titulo))
        $errores['titulo'] = 'El título es obligatorio.';
    if (empty($resumen))
        $errores['resumen'] = 'El resumen es obligatorio.';
    if (empty($contenido))
        $errores['contenido'] = 'El contenido es obligatorio.';

    if (empty($errores)) {
        $bd = conectarBD();
        $stmt = $bd->prepare(
            "INSERT INTO posts (titulo, slug, resumen, contenido, publicado)
       VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param('ssssi', $titulo, $slug, $resumen, $contenido, $publicado);
        $stmt->execute();
        $stmt->close();
        $bd->close();
        header('Location: ' . BASE_URL . '/admin/index.php?ok=guardado');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin — Nuevo post</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/admin.css" />
</head>

<body class="admin-body">

    <header class="admin-header">
        <span class="admin-header__logo">[VS<span class="acento">.</span>admin]</span>
        <nav class="admin-header__nav">
            <a href="<?= BASE_URL ?>/admin/index.php" class="admin-header__salir">← Volver</a>
        </nav>
    </header>

    <main class="admin-main contenedor">
        <div class="seccion-header">
            <span class="etiqueta">// nuevo post</span>
            <h2>Crear post<span class="acento">.</span></h2>
        </div>

        <form method="POST" action="<?= BASE_URL ?>/admin/newPost.php" class="contact-form admin-form">
            <div class="form-grupo">
                <label class="form-label" for="titulo">título</label>
                <input class="form-input" type="text" id="titulo" name="titulo"
                    value="<?= htmlspecialchars($_POST['titulo'] ?? '') ?>" />
                <?php if (!empty($errores['titulo'])): ?>
                    <span class="form-error"><?= $errores['titulo'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-grupo">
                <label class="form-label" for="resumen">resumen</label>
                <input class="form-input" type="text" id="resumen" name="resumen"
                    value="<?= htmlspecialchars($_POST['resumen'] ?? '') ?>" />
                <?php if (!empty($errores['resumen'])): ?>
                    <span class="form-error"><?= $errores['resumen'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-grupo">
                <label class="form-label" for="contenido">contenido (HTML permitido)</label>
                <textarea class="form-input form-textarea admin-textarea" id="contenido" name="contenido"
                    rows="14"><?= htmlspecialchars($_POST['contenido'] ?? '') ?></textarea>
                <?php if (!empty($errores['contenido'])): ?>
                    <span class="form-error"><?= $errores['contenido'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-grupo form-grupo--check">
                <label class="form-check">
                    <input type="checkbox" name="publicado" value="1" <?= isset($_POST['publicado']) ? 'checked' : '' ?> />
                    <span>Publicar ahora</span>
                </label>
            </div>

            <button type="submit" class="btn btn--primario">Guardar post</button>
        </form>
    </main>

</body>

</html>