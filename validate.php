<?php
// Configuración: ruta a tu archivo de licencias
$licensesFile = "licenses.json"; // o .ini si prefieres

// Obtener parámetros
$key = isset($_GET['key']) ? $_GET['key'] : '';
$website = isset($_GET['website']) ? $_GET['website'] : '';

// Leer licencias
if (!file_exists($licensesFile)) {
    echo "INVALID";
    exit;
}

$licensesJson = file_get_contents($licensesFile);
$licenses = json_decode($licensesJson, true); // array de licencias

$valid = false;

foreach ($licenses as $lic) {
    if ($lic['key'] === $key && $lic['website'] === $website) {
        // Si quieres validar duración:
        if (isset($lic['expiration'])) {
            $expiration = strtotime($lic['expiration']);
            if ($expiration < time()) {
                $valid = false;
                break;
            }
        }
        $valid = true;
        break;
    }
}

echo $valid ? "VALID" : "INVALID";
