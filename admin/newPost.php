<?php
require_once '../config/rutas.php';
require_once '../config/db.php';
require_once '../config/media.php';
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
    $tipo = $_POST['tipo'] ?? 'texto';
    $slug = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $titulo), '-'));

    if (!in_array($tipo, ['texto', 'imagen', 'video']))
        $tipo = 'texto';

    if (empty($titulo))
        $errores['titulo'] = 'El título es obligatorio.';
    if (empty($resumen))
        $errores['resumen'] = 'El resumen es obligatorio.';
    if (empty($contenido))
        $errores['contenido'] = 'El contenido es obligatorio.';

    // Subida de archivos\\
    $ruta_imagen = null;
    $ruta_video = null;
    $ruta_miniatura = null;
    $error_archivo = '';

    if ($tipo === 'imagen') {
        $ruta_imagen = subirArchivo('imagen', 'imagen', $error_archivo);
        if ($error_archivo)
            $errores['imagen'] = $error_archivo;
    }

    if ($tipo === 'video') {
        $ruta_video = subirArchivo('video', 'video', $error_archivo);
        if ($error_archivo)
            $errores['video'] = $error_archivo;
        $error_mini = '';
        $ruta_miniatura = subirArchivo('miniatura', 'imagen', $error_mini);
        if ($error_mini)
            $errores['miniatura'] = $error_mini;
    }

    if (empty($errores)) {
        $bd = conectarBD();
        $stmt = $bd->prepare(
            "INSERT INTO posts (titulo, slug, resumen, contenido, publicado, tipo, imagen, video, miniatura)
       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param(
            'ssssissss',
            $titulo,
            $slug,
            $resumen,
            $contenido,
            $publicado,
            $tipo,
            $ruta_imagen,
            $ruta_video,
            $ruta_miniatura
        );
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

        <form method="POST" action="<?= BASE_URL ?>/admin/newPost.php" class="contact-form admin-form"
            enctype="multipart/form-data">

            <!-- TIPO DE POST -->
            <div class="form-grupo">
                <label class="form-label">tipo de publicación</label>
                <div class="tipo-selector">
                    <label class="tipo-opcion <?= ($_POST['tipo'] ?? 'texto') === 'texto' ? 'activo' : '' ?>">
                        <input type="radio" name="tipo" value="texto" <?= ($_POST['tipo'] ?? 'texto') === 'texto' ? 'checked' : '' ?> />
                        <span>✦ Solo texto</span>
                    </label>
                    <label class="tipo-opcion <?= ($_POST['tipo'] ?? '') === 'imagen' ? 'activo' : '' ?>">
                        <input type="radio" name="tipo" value="imagen" <?= ($_POST['tipo'] ?? '') === 'imagen' ? 'checked' : '' ?> />
                        <span>▣ Imagen</span>
                    </label>
                    <label class="tipo-opcion <?= ($_POST['tipo'] ?? '') === 'video' ? 'activo' : '' ?>">
                        <input type="radio" name="tipo" value="video" <?= ($_POST['tipo'] ?? '') === 'video' ? 'checked' : '' ?> />
                        <span>▶ Vídeo</span>
                    </label>
                </div>
            </div>

            <!-- CAMPOS MEDIA (se muestran/ocultan con JS) -->
            <div class="form-grupo media-campo" id="campoImagen"
                style="<?= ($_POST['tipo'] ?? '') !== 'imagen' ? 'display:none' : '' ?>">
                <label class="form-label" for="imagen">imagen de portada</label>
                <input class="form-input" type="file" id="imagen" name="imagen"
                    accept="image/jpeg,image/png,image/webp,image/gif" />
                <span class="form-hint">JPG, PNG, WEBP o GIF — máx. 5MB</span>
                <?php if (!empty($errores['imagen'])): ?>
                    <span class="form-error"><?= $errores['imagen'] ?></span>
                <?php endif; ?>
            </div>

            <div class="media-campo" id="campoVideo"
                style="<?= ($_POST['tipo'] ?? '') !== 'video' ? 'display:none' : '' ?>">
                <div class="form-grupo">
                    <label class="form-label" for="video">vídeo</label>
                    <input class="form-input" type="file" id="video" name="video"
                        accept="video/mp4,video/webm,video/ogg" />
                    <span class="form-hint">MP4, WEBM u OGG — máx. 10MB</span>
                    <?php if (!empty($errores['video'])): ?>
                        <span class="form-error"><?= $errores['video'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-grupo">
                    <label class="form-label" for="miniatura">miniatura del vídeo</label>
                    <input class="form-input" type="file" id="miniatura" name="miniatura"
                        accept="image/jpeg,image/png,image/webp" />
                    <span class="form-hint">JPG, PNG o WEBP — máx. 5MB (opcional)</span>
                    <?php if (!empty($errores['miniatura'])): ?>
                        <span class="form-error"><?= $errores['miniatura'] ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- CAMPOS COMUNES -->
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
                    rows="10"><?= htmlspecialchars($_POST['contenido'] ?? '') ?></textarea>
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const radios = document.querySelectorAll('input[name="tipo"]');
            const campoImagen = document.getElementById('campoImagen');
            const campoVideo = document.getElementById('campoVideo');
            const tipoOpciones = document.querySelectorAll('.tipo-opcion');

            function actualizarCampos() {
                const seleccionado = document.querySelector('input[name="tipo"]:checked').value;

                campoImagen.style.display = seleccionado === 'imagen' ? '' : 'none';
                campoVideo.style.display = seleccionado === 'video' ? '' : 'none';

                tipoOpciones.forEach(op => {
                    op.classList.toggle('activo', op.querySelector('input').value === seleccionado);
                });
            }

            radios.forEach(r => r.addEventListener('change', actualizarCampos));
            actualizarCampos();
        });
    </script>

</body>

</html>