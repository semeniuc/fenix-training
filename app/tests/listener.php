<?php

use Beupsoft\Fenix\App\Service\InstallService;
use Beupsoft\Fenix\App\Bitrix;

try {
    // $install = new InstallService();
    // $response = $install->listener();

    // $response = Bitrix::call("event.get");

    dd(getenv("APP_PUBLIC_URL"));
    $response = Bitrix::callBatch([
        [
            "method" => "event.bind",
            "params" => [
                "event" => "ONOFFLINEEVENT",
                "handler" => getenv("APP_PUBLIC_URL"),
                'options' => [
                    'minTimeout' => 5,
                ],
            ],
        ]
    ]);


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