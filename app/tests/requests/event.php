<?php

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Service\EventCalendarService;

try {
    $eventId = 3408;
    // $response = Bitrix::call("calendar.event.get", [
    //     "type" => "user",
    //     "ownerId" => 572,
    // ]) ?? [];

    $eventCalendarService = new EventCalendarService();
    $response = $eventCalendarService->deleteEventCalendar($eventId);

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
