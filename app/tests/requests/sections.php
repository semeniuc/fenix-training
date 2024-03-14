<?php

use Beupsoft\Fenix\App\Bitrix;

try {

    $response = Bitrix::call("calendar.section.get", [
        "type" => "user",
        "ownerId" => 1,
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
