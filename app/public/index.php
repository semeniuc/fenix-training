<?php

use Beupsoft\Fenix\App\Kernel;

require_once (dirname(__DIR__) . "/vendor/autoload.php");

try {
    new Kernel($_SERVER["REQUEST_URI"]);

    // dd($_SERVER);
} catch (Exception $e) {
    echo json_encode([
        "code" => $e->getCode(),
        "message" => $e->getMessage(),
        "file" => $e->getFile(),
        "line" => $e->getLine(),
    ]);
}