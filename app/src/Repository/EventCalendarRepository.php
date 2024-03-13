<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;

# TODO: Настроить получение проверяемых полей и значений из конфига
class EventCalendarRepository
{
    public function get(int $eventId)
    {
        // $eventData = Bitrix::call("calendar.event.getbyid", ["id" => $eventId]);
        $eventData = Bitrix::call("calendar.event.get", [
            "id" => $eventId
        ]);

        // return new DealDTO($dealData);

        return $eventData;
    }

    public function add(array $data) 
    {
        $eventData = Bitrix::call("calendar.event.add", [
            "type" => "user",
            "ownerId" => 572,
            "accessibility" => "busy", 
            "from" => "",
            "to" => "",
            "section" => "",
            "name" => "",
            "is_meeting" => "Y",
            "location" => "",
            "attendees" => [],
            "color" => "#9cbe1c",
            "text_color" => "#283033",
        ]);
    }
}