<?php

use Beupsoft\Fenix\App\Bitrix;

try {
    $eventId = 3418;

    # find
     $response = Bitrix::call("crm.item.fields", [
        "entityTypeId" => 2,
         "filter" => [
             "TYPE" => "enumeration"
         ]
     ])["result"]["fields"] ?? [];


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
