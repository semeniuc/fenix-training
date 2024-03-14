<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;
use Beupsoft\Fenix\App\Repository\EventCalendarRepository;

class EventCalendarService
{
    private EventCalendarRepository $eventCalendarRepository;

    public function __construct()
    {
        $this->eventCalendarRepository = new EventCalendarRepository();
    }

    public function createEventCalendar(array $data) : EventCalendarDTO 
    {
        return  $this->eventCalendarRepository->add($data);
    }

    public function deleteEventCalendar(int $eventId): bool
    {
        return $this->eventCalendarRepository->del($eventId);
    }
}
