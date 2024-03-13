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
            "id" => (int )$data["ID"],
            "type" => $data["CAL_TYPE"],
            "ownerId" => (int) $data["OWNER_ID"],
            "section" => (int) $data["SECTION_ID"],
            "accessibility" => $data["ACCESSIBILITY"],
            "from" => $data["DATE_FROM"],
            "to" => $data["DATE_TO"],
            "name" => $data["NAME"],
            "description" => $data["DESCRIPTION"],
            "is_meeting" => $data["IS_MEETING"],
            "location" => $data["LOCATION"],
            "attendees" => (!empty($data["ATTENDEE_LIST"])) ? array_map(fn($item) => $item["id"], $data["ATTENDEE_LIST"]) : null,
            "color" => $data["COLOR"],
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
        ])["result"];
    }
}