<?php

use Beupsoft\Fenix\App\Service\InstallService;
use Beupsoft\Fenix\App\Bitrix;

try {
    // $install = new InstallService();
    // $response = $install->listener();

    $response = Bitrix::call("event.get");


    // $response = Bitrix::callBatch([
    //     [
    //         "method" => "event.bind",
    //         "params" => [
    //             "event" => "ONOFFLINEEVENT",
    //             "handler" => $_ENV["APP_PUBLIC_URL"] . "listener",
    //             'options' => [
    //                 'minTimeout' => 5,
    //             ],
    //         ],
    //     ]
    // ]);


    //     $response = Bitrix::callBatch([
    //     [
    //         "method" => "event.unbind",
    //         "params" => [
    //             "event" => "ONOFFLINEEVENT",
    //             "handler" => $_ENV["APP_PUBLIC_URL"]. "/listener",
    //         ],
    //     ]
    // ]);





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