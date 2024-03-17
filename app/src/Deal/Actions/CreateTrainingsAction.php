<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Actions;

use Beupsoft\Fenix\App\Deal\DealDTO;
use Beupsoft\Fenix\App\Deal\DealRepository;
use Beupsoft\Fenix\App\Deal\Tools\GenerateSchedule;

class CreateTrainingsAction
{
    private DealRepository $dealRepository;

    public function __construct(private readonly DealDTO $dealDTO)
    {
        $this->dealRepository = new DealRepository();
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
            }

            // Set conflict status
            if (!empty($unavailableTime)) {
                $this->setConflictStatusForTrainings($unavailableTime);
            }
        }


        dd([
            "unavailableTime" => $unavailableTime,
            "availableTime" => $availableTime,
            "trainingsCollection" => $trainingsCollection,
            "events" => $events,
        ]);
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

        return $this->dealRepository->createTrainings($data);
    }

    private function getUnavailableTime(array $trainingsCollection)
    {
        return $this->dealRepository->getUnavailableTime($trainingsCollection);
    }

    private function createEvents(array $trainingsCollection): array
    {
        return $this->dealRepository->createEvents($trainingsCollection);
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

        $this->dealRepository->updateTrainings($data);
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

        $this->dealRepository->updateTrainings($data);
    }
}