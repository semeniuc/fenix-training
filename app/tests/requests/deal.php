<?php

try {
    $dealId = 1338;
    $response = new \Beupsoft\Fenix\App\Deal\DealController($dealId);
} catch (Throwable $th) {
    $response = [
        'code' => $th->getCode(),
        'message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
    ];
} finally {
    dd($response);
}
