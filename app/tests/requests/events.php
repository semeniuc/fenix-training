<?php

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Listener;


try {
    function getEvents(): array
    {
        return Bitrix::call("event.offline.get")["result"]["events"] ?? [];
    }

//    $response = getEvents();
    // $response = ["test"];


    $response = new Listener();
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
