<?php
require_once 'config/rutas.php';
$errores = [];
$mensaje_exito = '';
$mensaje_error = '';

$seo_titulo = 'Contacto — Víctor Suárez Dev';
$seo_descripcion = '¿Tienes un proyecto en mente? Escríbeme y hablamos.';
$seo_url = 'http://localhost' . BASE_URL . '/contacto.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Sanitizar entradas
  $nombre = trim(htmlspecialchars($_POST['nombre'] ?? ''));
  $email = trim(htmlspecialchars($_POST['email'] ?? ''));
  $asunto = trim(htmlspecialchars($_POST['asunto'] ?? ''));
  $mensaje = trim(htmlspecialchars($_POST['mensaje'] ?? ''));

  // Validaciones
  if (empty($nombre)) {
    $errores['nombre'] = 'El nombre es obligatorio.';
  } elseif (strlen($nombre) < 2) {
    $errores['nombre'] = 'El nombre debe tener al menos 2 caracteres.';
  }

  if (empty($email)) {
    $errores['email'] = 'El email es obligatorio.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errores['email'] = 'Introduce un email válido.';
  }

  if (empty($asunto)) {
    $errores['asunto'] = 'El asunto es obligatorio.';
  }

  if (empty($mensaje)) {
    $errores['mensaje'] = 'El mensaje es obligatorio.';
  } elseif (strlen($mensaje) < 10) {
    $errores['mensaje'] = 'El mensaje debe tener al menos 10 caracteres.';
  }

  // Si no hay errores, enviar
  if (empty($errores)) {
    $destinatario = 'vjavier170103@gmail.com';
    $asunto_mail = '[Portfolio] ' . $asunto;
    $cuerpo = "Nombre: $nombre\nEmail: $email\n\nMensaje:\n$mensaje";
    $cabeceras = "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

    $enviado = mail($destinatario, $asunto_mail, $cuerpo, $cabeceras);

    if ($enviado) {
      $mensaje_exito = '¡Mensaje enviado! Te respondo en menos de 24h.';
      $_POST = [];
    } else {
      $mensaje_error = 'Hubo un problema al enviar. Prueba a escribirme directamente.';
    }
  }
}
?>
<?php include 'includes/header.php'; ?>

<!-- CONTACT HERO -->
<section class="contact-hero">
  <div class="contenedor">
    <span class="etiqueta">// contacto</span>
    <h1>Hablemos<span class="acento">.</span></h1>
    <p>¿Tienes un proyecto en mente o simplemente quieres saludar?<br>
      Escríbeme y te respondo en menos de 24h.</p>
  </div>
</section>
<!-- CONTACT MAIN -->
<section class="contact-main">
  <div class="contenedor contact-main__grid">

    <!-- FORMULARIO -->
    <div class="contact-form__wrapper">

      <?php if (!empty($mensaje_exito)): ?>
        <div class="contact-alert contact-alert--ok">
          <span>✓</span> <?= htmlspecialchars($mensaje_exito) ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($mensaje_error)): ?>
        <div class="contact-alert contact-alert--error">
          <span>✗</span> <?= htmlspecialchars($mensaje_error) ?>
        </div>
      <?php endif; ?>

      <form class="contact-form" method="POST" action="contacto.php" novalidate>

        <div class="form-grupo">
          <label class="form-label" for="nombre">nombre</label>
          <input class="form-input" type="text" id="nombre" name="nombre" placeholder="Tu nombre completo"
            value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>" autocomplete="off" />
          <?php if (!empty($errores['nombre'])): ?>
            <span class="form-error"><?= $errores['nombre'] ?></span>
          <?php endif; ?>
        </div>

        <div class="form-grupo">
          <label class="form-label" for="email">email</label>
          <input class="form-input" type="email" id="email" name="email" placeholder="tu@email.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" autocomplete="off" />
          <?php if (!empty($errores['email'])): ?>

            <span class="form-error"><?= $errores['email'] ?></span>
          <?php endif; ?>
        </div>

        <div class="form-grupo">
          <label class="form-label" for="asunto">asunto</label>
          <input class="form-input" type="text" id="asunto" name="asunto" placeholder="¿De qué va esto?"
            value="<?= htmlspecialchars($_POST['asunto'] ?? '') ?>" autocomplete="off" />
          <?php if (!empty($errores['asunto'])): ?>
            <span class="form-error"><?= $errores['asunto'] ?></span>
          <?php endif; ?>
        </div>

        <div class="form-grupo">
          <label class="form-label" for="mensaje">mensaje</label>
          <textarea class="form-input form-textarea" id="mensaje" name="mensaje" placeholder="Cuéntame..."
            rows="6"><?= htmlspecialchars($_POST['mensaje'] ?? '') ?></textarea>
          <?php if (!empty($errores['mensaje'])): ?>
            <span class="form-error"><?= $errores['mensaje'] ?></span>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn--primario btn--full">
          Enviar mensaje
        </button>

      </form>
    </div>

    <!-- INFO LATERAL -->
    <aside class="contact-info">

      <div class="contact-info__bloque">
        <span class="etiqueta">// email</span>
        <a href="mailto:vjavier170103@gmail.com" class="contact-info__enlace">
          vjavier170103@gmail.com
        </a>
      </div>

      <div class="contact-info__bloque">
        <span class="etiqueta">// ubicación</span>
        <p>Valencia, España</p>
      </div>

      <div class="contact-info__bloque">
        <span class="etiqueta">// redes</span>
        <div class="contact-info__redes">
          <a href="https://github.com/Vito-Pulls" target="_blank" rel="noopener" class="contact-info__red">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path
                d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22" />
            </svg>
            GitHub
          </a>
          <a href="https://www.linkedin.com/in/vitopulls" target="_blank" rel="noopener"
            class="contact-info__red">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              <path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z" />
              <rect x="2" y="9" width="4" height="12" />
              <circle cx="4" cy="4" r="2" />
            </svg>
            LinkedIn
          </a>
        </div>
      </div>

    </aside>

  </div>
</section>

<?php include 'includes/footer.php'; ?>