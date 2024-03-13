<?php

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Service\EventCalendarService;

try {

    $response = Bitrix::call("calendar.event.get", [
        "type" => "user",
        "ownerId" => 572,
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
