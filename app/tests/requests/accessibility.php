<?php

use Beupsoft\Fenix\App\Bitrix;

try {
    $eventId = 3418;

    # find
     $response = Bitrix::call("calendar.accessibility.get", [
         "users" => [572],
         "from" => "2024-03-23 17:05:00",
         "to" => "2024-03-23 18:05:00"

     ]) ?? [];


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
