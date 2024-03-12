<?php

use Beupsoft\Fenix\App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require_once (dirname(__DIR__) . "/vendor/autoload.php");
try {
    $dotenv = new Dotenv();
    $dotenv->load("../.env", "../.env.dev");
    new Kernel($_SERVER["REQUEST_URI"]);
} catch (Exception $e) {
    echo json_encode([
        "code" => $e->getCode(),
        "message" => $e->getMessage(),
        "file" => $e->getFile(),
        "line" => $e->getLine(),
    ]);
}