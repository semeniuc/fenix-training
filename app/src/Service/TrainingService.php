<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\TrainingDTO;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;
use Beupsoft\Fenix\App\Repository\TrainingRepository;
use Beupsoft\Fenix\App\Repository\EventCalendarRepository;

class TrainingService
{
    private TrainingRepository $trainingRepository;
    private EventCalendarRepository $eventCalendarRepository;

    public function __construct()
    {
        $this->trainingRepository = new TrainingRepository();
        $this->eventCalendarRepository = new EventCalendarRepository();
    }

    public function getTraining(int $trainingId): TrainingDTO
    {
        return $this->trainingRepository->get($trainingId);
    }

    public function createEventCalendarForTraining(int $trainingId) 
    {
        $trainingDTO = $this->getTraining($trainingId);

        $trainingId = $trainingDTO->getId();
        $title = $trainingDTO->getTitle();
        $datetime = $trainingDTO->getDatetimeTraining();

        $from = ($datetime) ? $datetime->format("Y-m-d H:i:s") : null;
        $to = ($datetime) ? $datetime->modify("+1 hour")->format("Y-m-d H:i:s") : null;

        $eventCalendar = new EventCalendarService();
        $eventCalendar->createEventCalendar([
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
}
