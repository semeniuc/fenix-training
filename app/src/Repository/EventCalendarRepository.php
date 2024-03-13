<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;
use DateTime;

# TODO: Настроить получение проверяемых полей и значений из конфига
class EventCalendarRepository
{
    public function get(int $eventId): EventCalendarDTO
    {
        $data = Bitrix::call("calendar.event.getbyid", ["id" => $eventId])["result"];

        $eventCalendarDTO = new EventCalendarDTO([
            "id" => $data["ID"] ?? null,
            "type" => $data["CAL_TYPE"] ?? null,
            "ownerId" => $data["OWNER_ID"] ?? null,
            "section" => $data["SECTION_ID"] ?? null,
            "accessibility" => $data["ACCESSIBILITY"] ?? null,
            "from" => $data["DATE_FROM"] ?? null,
            "to" => $data["DATE_TO"] ?? null,
            "name" => $data["NAME"] ?? null,
            "description" => $data["DESCRIPTION"] ?? null,
            "is_meeting" => $data["IS_MEETING"] ?? null,
            "location" => $data["LOCATION"] ?? null,
            "attendees" => (!empty($data["ATTENDEE_LIST"])) ? array_map(fn($item) => $item["id"], $data["ATTENDEE_LIST"]) : null,
            "color" => $data["COLOR"] ?? null,
        ]);

        return $eventCalendarDTO;
    }

    public function add(array $data): EventCalendarDTO
    {
        $eventCalendarDTO = new EventCalendarDTO($data);
        
        $eventData = Bitrix::call("calendar.event.add", [
            "type" => "user",
            "ownerId" => 572,
            "section" => 132,

            "accessibility" => "busy", 
            "from" => "",
            "to" => "",
            "name" => "",
            "is_meeting" => "Y",
            "location" => "",
            "attendees" => [],
            "color" => "#9cbe1c",
            "text_color" => "#283033",
        ]);

        return $eventCalendarDTO;
    }

    public function del(int $eventId): bool
    {
        $eventCalendarDTO = $this->get($eventId);

        return Bitrix::call("calendar.event.delete", [
            "id" => $eventCalendarDTO->getId(),
            "type" => $eventCalendarDTO->getType(),
            "ownerId" => $eventCalendarDTO->getOwnerId(),
        ])["result"] ?? false;
    }
}