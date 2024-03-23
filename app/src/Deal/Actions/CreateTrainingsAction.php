<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Actions;

use Beupsoft\Fenix\App\Deal\DealDTO;
use Beupsoft\Fenix\App\Deal\Repository\DealRepository;
use Beupsoft\Fenix\App\Deal\Repository\EventRepository;
use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;
use Beupsoft\Fenix\App\Deal\Tools\GenerateSchedule;

class CreateTrainingsAction
{
    private DealRepository $dealRepository;
    private TrainingRepository $trainingRepository;
    private EventRepository $eventRepository;

    public function __construct(private readonly DealDTO $dealDTO)
    {
        $this->dealRepository = new DealRepository();
        $this->trainingRepository = new TrainingRepository();
        $this->eventRepository = new EventRepository();
    }

    public function execute()
    {
        $trainingSchedule = $this->generateSchedule();

        if ($trainingSchedule) {
            // Create trainings
            $trainingsCollection = $this->createTrainings($trainingSchedule);

            // Get time statuses
            $unavailableTime = $this->getUnavailableTime($trainingsCollection);
            $availableTime = array_diff_key($trainingsCollection, $unavailableTime);

            // Create events
            if (!empty($availableTime)) {
                $events = $this->createEvents($availableTime);
                $this->setLinkEventsToTrainings($availableTime, $events);

                // Update deal
                $this->updateDeal();
            }

            // Set conflict status
            if (!empty($unavailableTime)) {
                $this->setConflictStatusForTrainings($unavailableTime);
            }
        }
    }

    private function generateSchedule(): array
    {
        $schedule = new GenerateSchedule(
            $this->dealDTO->getStartDate(),
            $this->dealDTO->getDaysAndTime(),
            $this->dealDTO->getNumberTrainings()
        );

        return $schedule->get();
    }

    private function createTrainings(array $datetimeCollection): array
    {
        $data = [];
        foreach ($datetimeCollection as $datetime) {
            $data[] = [
                "title" => $this->dealDTO->getTitle(),
                "assignedById" => $this->dealDTO->getAssignedById(),
                "datetimeTraining" => $datetime->format("Y-m-d H:i:s"),
                "dealId" => $this->dealDTO->getId(),
                "contactId" => $this->dealDTO->getContactId(),
            ];
        }

        return $this->trainingRepository->createTrainings($data);
    }

    private function getUnavailableTime(array $trainingsCollection)
    {
        return $this->eventRepository->getUnavailableTime($trainingsCollection);
    }

    private function createEvents(array $trainingsCollection): array
    {
        return $this->eventRepository->createEvents($trainingsCollection);
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

    private function setConflictStatusForTrainings(array $trainingsCollection): void
    {
        $data = [];
        foreach ($trainingsCollection as $trainingDto) {
            $trainingId = $trainingDto->getId();

            $data[] = [
                "id" => $trainingId,
                "fields" => [
                    "stageId" => "DT149_30:PREPARATION",
                ],
            ];
        }

        $this->trainingRepository->updateTrainings($data);
    }

    private function updateDeal(): void
    {
        $this->dealRepository->updateDeal($this->dealDTO->getId(), [
            "lastStageAppLaunch" => $this->dealDTO->getStageId(),
        ]);
    }
}