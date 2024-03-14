<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\TrainingDTO;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;
use Beupsoft\Fenix\App\Repository\TrainingRepository;

class TrainingService
{
    private TrainingRepository $trainingRepository;
    private EventCalendarService $eventCalendar;

    public function __construct()
    {
        $this->trainingRepository = new TrainingRepository();
        $this->eventCalendar = new EventCalendarService();
    }

    public function handle(int $trainingId, string $eventType): void
    {
        $trainingDTO = $this->getTraining($trainingId);
        # Delete old event
        if ($eventId = $trainingDTO->getEventId()) {
            $this->deleteEventCalendarFromTraining($eventId);
        }

        if ($trainingDTO->getStageId() !== "DT149_30:FAIL") {
            # Create event
            $eventCalendarDTO = $this->createEventCalendarForTraining($trainingDTO);

            # Save event
            if ($eventId = $eventCalendarDTO->getId()) {
                $this->addEventCalendarToTraining($trainingId, $eventId);
            }
        }
    }

    public function getTraining(int $trainingId): TrainingDTO
    {
        return $this->trainingRepository->get($trainingId);
    }

    private function createEventCalendarForTraining(TrainingDTO $trainingDTO): EventCalendarDTO
    {
        $trainingId = $trainingDTO->getId();
        $title = $trainingDTO->getTitle();
        $datetime = $trainingDTO->getDatetimeTraining();

        $from = ($datetime) ? $datetime->format("Y-m-d H:i:s") : null;
        $to = ($datetime) ? $datetime->modify("+1 hour")->format("Y-m-d H:i:s") : null;

        return $this->eventCalendar->createEventCalendar([
            "type" => "user",
            "ownerId" => 572,
            "section" => 132,
            "accessibility" => "busy",
            "from" => $from,
            "to" => $to,
            "name" => $title,
            "description" => "<b><a href=\"https://fenixtraining.bitrix24.pl/page/trenerzy/treningi/type/149/details/{$trainingId}/\">EDYTUJ TRENING</a></b>",
            "is_meeting" => "Y",
            "location" => "",
            "attendees" => [572],
            "color" => "#9cbe1c",
            "text_color" => "#283033",
        ]);
    }

    private function addEventCalendarToTraining(int $trainingId, int $eventId): bool
    {
        return $this->trainingRepository->upd($trainingId, [
            "ufCrm22EventId" => $eventId,
        ]);
    }

    private function deleteEventCalendarFromTraining(int $eventId): bool
    {
        return $this->eventCalendar->deleteEventCalendar($eventId);
    }
}
