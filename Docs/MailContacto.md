# Formulario de contacto y envío de email

El formulario de contacto está en `contacto.php`.
Usa la función `mail()` nativa de PHP para enviar emails.

## Flujo

1. El usuario rellena nombre, email, asunto y mensaje
2. Al enviar, PHP valida todos los campos en el servidor
3. Si hay errores, se muestran campo a campo sin perder los datos escritos
4. Si todo es correcto, se envía el email con `mail()`
5. Se muestra mensaje de éxito o error según el resultado

## Validaciones
```php
// Nombre obligatorio, mínimo 2 caracteres
if (empty($nombre) || strlen($nombre) < 2) { ... }

// Email válido
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { ... }

// Mensaje obligatorio, mínimo 10 caracteres
if (empty($mensaje) || strlen($mensaje) < 10) { ... }
```

## Envío del email
```php
$destinatario = 'victor@example.com';
$asunto_mail  = '[Portfolio] ' . $asunto;
$cuerpo       = "Nombre: $nombre\nEmail: $email\n\nMensaje:\n$mensaje";
$cabeceras    = "From: $email\r\nReply-To: $email\r\nX-Mailer: PHP/" . phpversion();

$enviado = mail($destinatario, $asunto_mail, $cuerpo, $cabeceras);
```

## Limitaciones de `mail()` en local

La función `mail()` de PHP en local (Docker o XAMPP) no envía emails reales
— no hay servidor de correo configurado.