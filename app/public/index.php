<?php

use Beupsoft\Fenix\App\Kernel;
use Symfony\Component\Dotenv\Dotenv;

require_once (dirname(__DIR__) . "/vendor/autoload.php");
try {
    $dotenv = new Dotenv();
    $dotenv->load("../.env");
    // new Kernel($_SERVER["REQUEST_URI"]);


    // require_once (dirname(__DIR__) . "/tests/listener.php");

    // dd(getenv("BITRIX24_CLIENT_ID"));
    // dd($_ENV["APP_PUBLIC_URL"]);
    dd($_ENV);

    // dd($_SERVER);

} catch (Exception $e) {
    echo json_encode([
        "code" => $e->getCode(),
        "message" => $e->getMessage(),
        "file" => $e->getFile(),
        "line" => $e->getLine(),
    ]);
}