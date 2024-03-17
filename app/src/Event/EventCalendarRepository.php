<?php

namespace Beupsoft\Fenix\App\Event;

use Beupsoft\App\Config\EventCalendarConfig;
use Beupsoft\Fenix\App\Bitrix;
use DateTime;

class EventCalendarRepository
{
    private array $ownerCalendar;

    public function __construct()
    {
        $this->ownerCalendar = EventCalendarConfig::getOwnerCalendar();
    }

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
            "attendees" => (!empty($data["ATTENDEE_LIST"])) ? array_map(fn($item) => $item["id"],
                $data["ATTENDEE_LIST"]) : null,
            "color" => $data["COLOR"] ?? null,
        ]);

        return $eventCalendarDTO;
    }

    public function add(array $data): EventCalendarDTO
    {
        $eventCalendarDTO = new EventCalendarDTO($data);

        $postData = array_merge($this->ownerCalendar, [
            "accessibility" => $eventCalendarDTO->getAccessibility(),
            "from" => ($eventCalendarDTO->getFrom()) ? $eventCalendarDTO->getFrom()->format("Y-m-d H:i:s") : null,
            "to" => ($eventCalendarDTO->getTo()) ? $eventCalendarDTO->getTo()->format("Y-m-d H:i:s") : null,
            "name" => $eventCalendarDTO->getName(),
            "description" => $eventCalendarDTO->getDescription(),
            "is_meeting" => $eventCalendarDTO->getIsmeeting(),
            "location" => $eventCalendarDTO->getLocation(),
            "attendees" => $eventCalendarDTO->getAttendees(),
            "color" => $eventCalendarDTO->getColor(),
            "text_color" => $eventCalendarDTO->getTextColor(),
        ]);

        $eventId = Bitrix::call("calendar.event.add", $postData)["result"];
        $eventCalendarDTO->setId($eventId);

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

    public function isTimeAvailable(int $userId, DateTime $from, DateTime $to): bool
    {
        $response = Bitrix::call("calendar.accessibility.get", [
            "users" => [$userId],
            "from" => $from->format("Y-m-d H:i:s"),
            "to" => $to->format("Y-m-d H:i:s"),

        ])["result"][$userId] ?? [];

        return empty($response);
    }
}