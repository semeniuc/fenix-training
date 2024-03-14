<?php

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Service\EventCalendarService;

try {
    $eventId = 3418;

    # find
    // $response = Bitrix::call("calendar.event.get", [
    //     "type" => "user",
    //     "ownerId" => 572,
    // ]) ?? [];

    # add
    // $response = Bitrix::call("calendar.event.add", [
    //     "type" => "user",
    //     "ownerId" => 572,
    //     "section" => 132,
    //     "accessibility" => "busy", 
    //     "from" => "2024-03-13 18:15:00",
    //     "to" => "2024-03-13 19:15:00",
    //     "name" => "My test",
    //     "is_meeting" => "Y",
    //     "location" => "",
    //     "attendees" => [572],
    //     "color" => "#9cbe1c",
    //     "text_color" => "#283033",
    // ])["result"];

    # delete
    // $response = Bitrix::call("calendar.event.delete", [
    //     "id" => $eventId,
    //     "type" => "user",
    //     "ownerId" => 572,
    // ])["result"];

    $config = \Beupsoft\App\Config\EventCalendarConfig::getOwnerCalendar();

    $eventCalendarService = new EventCalendarService();
    // $response = $eventCalendarService->deleteEventCalendar($eventId);

    $data = array_merge($config, [
        "accessibility" => "busy",
        "from" => "2024-03-15 18:15:00",
        "to" => "2024-03-15 19:15:00",
        "name" => "My test",
        "description" => "<b><a href=\"https://fenixtraining.bitrix24.pl/page/trenerzy/treningi/type/149/details/4/\">EDYTUJ TRENING</a></b>",
        "is_meeting" => "Y",
        "location" => "",
        "attendees" => [572],
        "color" => "#9cbe1c",
        "text_color" => "#283033",
    ]);

    dd($data);

    $response = $eventCalendarService->createEventCalendar($data);

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
