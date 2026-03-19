<?php
// Detecta automáticamente el subdirectorio del proyecto
define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\'));
define('BASE_URL_ADMIN', rtrim(dirname(dirname($_SERVER['SCRIPT_NAME'])), '/\\'));