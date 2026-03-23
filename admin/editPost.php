<?php
require_once '../config/rutas.php';
require_once '../config/db.php';
require_once '../config/media.php';
session_start();

if (!isset($_SESSION['admin_logueado'])) {
    header('Location: ' . BASE_URL . '/admin/login.php');
    exit;
}

$bd = conectarBD();
$id = (int) ($_GET['id'] ?? 0);
$errores = [];

$stmt = $bd->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$post) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}

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

    // Gestión de archivos — solo reemplaza si se sube uno nuevo\\
    $ruta_imagen = $post['imagen'];
    $ruta_video = $post['video'];
    $ruta_miniatura = $post['miniatura'];
    $error_archivo = '';

    if ($tipo === 'imagen' && !empty($_FILES['imagen']['name'])) {
        $nueva = subirArchivo('imagen', 'imagen', $error_archivo);
        if ($error_archivo) {
            $errores['imagen'] = $error_archivo;
        } else {
            eliminarArchivo($ruta_imagen);
            $ruta_imagen = $nueva;
        }
    }

    if ($tipo === 'video') {
        if (!empty($_FILES['video']['name'])) {
            $nuevo_video = subirArchivo('video', 'video', $error_archivo);
            if ($error_archivo) {
                $errores['video'] = $error_archivo;
            } else {
                eliminarArchivo($ruta_video);
                $ruta_video = $nuevo_video;
            }
        }
        if (!empty($_FILES['miniatura']['name'])) {
            $error_mini = '';
            $nueva_mini = subirArchivo('miniatura', 'imagen', $error_mini);
            if ($error_mini) {
                $errores['miniatura'] = $error_mini;
            } else {
                eliminarArchivo($ruta_miniatura);
                $ruta_miniatura = $nueva_mini;
            }
        }
    }

    // Si cambia de tipo, limpia archivos del tipo anterior\\
    if ($tipo !== $post['tipo']) {
        if ($post['tipo'] === 'imagen') {
            eliminarArchivo($post['imagen']);
            $ruta_imagen = null;
        }
        if ($post['tipo'] === 'video') {
            eliminarArchivo($post['video']);
            eliminarArchivo($post['miniatura']);
            $ruta_video = null;
            $ruta_miniatura = null;
        }
    }

    if (empty($errores)) {
        $stmt = $bd->prepare(
            "UPDATE posts
       SET titulo=?, slug=?, resumen=?, contenido=?, publicado=?,
           tipo=?, imagen=?, video=?, miniatura=?
       WHERE id=?"
        );
        $stmt->bind_param(
            'ssssissssi',
            $titulo,
            $slug,
            $resumen,
            $contenido,
            $publicado,
            $tipo,
            $ruta_imagen,
            $ruta_video,
            $ruta_miniatura,
            $id
        );
        $stmt->execute();
        $stmt->close();
        $bd->close();
        header('Location: ' . BASE_URL . '/admin/index.php?ok=guardado');
        exit;
    }

    $post = array_merge($post, [
        'titulo' => $titulo,
        'resumen' => $resumen,
        'contenido' => $contenido,
        'publicado' => $publicado,
        'tipo' => $tipo,
    ]);
}

$bd->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin — Editar post</title>
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
            <span class="etiqueta">// editar post</span>
            <h2>Editando<span class="acento">.</span></h2>
        </div>

        <form method="POST" action="<?= BASE_URL ?>/admin/editPost.php?id=<?= $id ?>" class="contact-form admin-form"
            enctype="multipart/form-data">

            <!-- TIPO -->
            <div class="form-grupo">
                <label class="form-label">tipo de publicación</label>
                <div class="tipo-selector">
                    <label class="tipo-opcion <?= $post['tipo'] === 'texto' ? 'activo' : '' ?>">
                        <input type="radio" name="tipo" value="texto" <?= $post['tipo'] === 'texto' ? 'checked' : '' ?> />
                        <span>✦ Solo texto</span>
                    </label>
                    <label class="tipo-opcion <?= $post['tipo'] === 'imagen' ? 'activo' : '' ?>">
                        <input type="radio" name="tipo" value="imagen" <?= $post['tipo'] === 'imagen' ? 'checked' : '' ?> />
                        <span>▣ Imagen</span>
                    </label>
                    <label class="tipo-opcion <?= $post['tipo'] === 'video' ? 'activo' : '' ?>">
                        <input type="radio" name="tipo" value="video" <?= $post['tipo'] === 'video' ? 'checked' : '' ?> />
                        <span>▶ Vídeo</span>
                    </label>
                </div>
            </div>

            <!-- CAMPO IMAGEN -->
            <div class="form-grupo media-campo" id="campoImagen"
                style="<?= $post['tipo'] !== 'imagen' ? 'display:none' : '' ?>">
                <label class="form-label">imagen de portada</label>
                <?php if (!empty($post['imagen'])): ?>
                    <div class="media-preview">
                        <img src="<?= BASE_URL . htmlspecialchars($post['imagen']) ?>" alt="Portada actual" />
                        <span class="form-hint">Imagen actual — sube una nueva para reemplazarla</span>
                    </div>
                <?php endif; ?>
                <input class="form-input" type="file" name="imagen"
                    accept="image/jpeg,image/png,image/webp,image/gif" />
                <span class="form-hint">JPG, PNG, WEBP o GIF — máx. 5MB</span>
                <?php if (!empty($errores['imagen'])): ?>
                    <span class="form-error"><?= $errores['imagen'] ?></span>
                <?php endif; ?>
            </div>

            <!-- CAMPOS VÍDEO -->
            <div class="media-campo" id="campoVideo" style="<?= $post['tipo'] !== 'video' ? 'display:none' : '' ?>">
                <div class="form-grupo">
                    <label class="form-label">vídeo</label>
                    <?php if (!empty($post['video'])): ?>
                        <div class="media-preview">
                            <video src="<?= BASE_URL . htmlspecialchars($post['video']) ?>" controls muted
                                style="max-height:120px"></video>
                            <span class="form-hint">Vídeo actual — sube uno nuevo para reemplazarlo</span>
                        </div>
                    <?php endif; ?>
                    <input class="form-input" type="file" name="video" accept="video/mp4,video/webm,video/ogg" />
                    <span class="form-hint">MP4, WEBM u OGG — máx. 10MB</span>
                    <?php if (!empty($errores['video'])): ?>
                        <span class="form-error"><?= $errores['video'] ?></span>
                    <?php endif; ?>
                </div>
                <div class="form-grupo">
                    <label class="form-label">miniatura del vídeo</label>
                    <?php if (!empty($post['miniatura'])): ?>
                        <div class="media-preview">
                            <img src="<?= BASE_URL . htmlspecialchars($post['miniatura']) ?>" alt="Miniatura actual" />
                            <span class="form-hint">Miniatura actual — sube una nueva para reemplazarla</span>
                        </div>
                    <?php endif; ?>
                    <input class="form-input" type="file" name="miniatura" accept="image/jpeg,image/png,image/webp" />
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
                    value="<?= htmlspecialchars($post['titulo']) ?>" />
                <?php if (!empty($errores['titulo'])): ?>
                    <span class="form-error"><?= $errores['titulo'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-grupo">
                <label class="form-label" for="resumen">resumen</label>
                <input class="form-input" type="text" id="resumen" name="resumen"
                    value="<?= htmlspecialchars($post['resumen']) ?>" />
                <?php if (!empty($errores['resumen'])): ?>
                    <span class="form-error"><?= $errores['resumen'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-grupo">
                <label class="form-label" for="contenido">contenido (HTML permitido)</label>
                <textarea class="form-input form-textarea admin-textarea" id="contenido" name="contenido"
                    rows="10"><?= htmlspecialchars($post['contenido']) ?></textarea>
                <?php if (!empty($errores['contenido'])): ?>
                    <span class="form-error"><?= $errores['contenido'] ?></span>
                <?php endif; ?>
            </div>

            <div class="form-grupo form-grupo--check">
                <label class="form-check">
                    <input type="checkbox" name="publicado" value="1" <?= $post['publicado'] ? 'checked' : '' ?> />
                    <span>Publicar</span>
                </label>
            </div>

            <button type="submit" class="btn btn--primario">Guardar cambios</button>
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