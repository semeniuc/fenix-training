<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;
use Beupsoft\Fenix\App\Repository\EventCalendarRepository;

class EventCalendarService
{
    private EventCalendarRepository $eventCalendarRepository;
    private EventCalendarDTO $eventCalendarDTO;

    public function __construct(?int $eventId)
    {
        $this->eventCalendarRepository = new EventCalendarRepository();

        if ($eventId) {
            $this->eventCalendarDTO = $this->getEventCalendar($eventId);
        } else {

        }
        

        dd($this->eventCalendarDTO);
    }

    public function handle(): void
    {
        
    }

    private function getEventCalendar(int $eventId): EventCalendarDTO
    {
        return  $this->eventCalendarRepository->get($eventId);
    }

    private function createEventCalendar() : EventCalendarDTO 
    {
        
    }
}
