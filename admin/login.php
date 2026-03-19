<?php
require_once '../config/rutas.php';
session_start();

if (isset($_SESSION['admin_logueado'])) {
    header('Location: ' . BASE_URL . '/admin/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');

    $usuario_valido = 'victor';
    $contrasena_valida = 'admin1234';

    if ($usuario === $usuario_valido && $contrasena === $contrasena_valida) {
        $_SESSION['admin_logueado'] = true;
        $_SESSION['admin_usuario'] = $usuario;
        header('Location: ' . BASE_URL . '/admin/index.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin — Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/admin/admin.css" />
</head>

<body class="admin-body">

    <div class="login-wrapper">
        <div class="login-box">
            <div class="login-box__cabecera">
                <span class="nav__logo-corchete">[</span>VS<span class="acento">.</span>admin<span
                    class="nav__logo-corchete">]</span>
                <p>Acceso restringido</p>
            </div>

            <?php if ($error): ?>
                <div class="contact-alert contact-alert--error"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/admin/login.php" class="contact-form">
                <div class="form-grupo">
                    <label class="form-label" for="usuario">usuario</label>
                    <input class="form-input" type="text" id="usuario" name="usuario" autocomplete="off"
                        placeholder="tu usuario" />
                </div>
                <div class="form-grupo">
                    <label class="form-label" for="contrasena">contraseña</label>
                    <input class="form-input" type="password" id="contrasena" name="contrasena"
                        placeholder="••••••••" />
                </div>
                <button type="submit" class="btn btn--primario btn--full">Entrar</button>
            </form>
        </div>
    </div>

</body>

</html>