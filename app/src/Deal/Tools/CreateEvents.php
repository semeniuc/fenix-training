<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Tools;

use Beupsoft\Fenix\App\Deal\Repository\EventRepository;
use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;

class CreateEvents
{
    private TrainingRepository $trainingRepository;
    private EventRepository $eventRepository;

    public function __construct()
    {
        $this->trainingRepository = new TrainingRepository();
        $this->eventRepository = new EventRepository();
    }

    public function createEvents(array $trainingsCollection): void
    {
        $events = $this->eventRepository->createEvents($trainingsCollection);

        if (!empty($events)) {
            $this->setLinkEventsToTrainings($trainingsCollection, $events);
        }
    }

    private function setLinkEventsToTrainings(array $trainingsCollection, array $events): void
    {
        $data = [];
        foreach ($trainingsCollection as $trainingDto) {
            $trainingId = $trainingDto->getId();

            if (isset($events[$trainingId])) {
                $data[] = [
                    "id" => $trainingId,
                    "fields" => [
                        "eventId" => $events[$trainingId],
                    ],
                ];
            }
        }

        $this->trainingRepository->updateTrainings($data);
    }
}