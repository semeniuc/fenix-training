<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Actions;

use Beupsoft\Fenix\App\Deal\DealDTO;
use Beupsoft\Fenix\App\Deal\Repository\EventRepository;
use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;
use Beupsoft\Fenix\App\Deal\Tools\CreateEvents;
use Beupsoft\Fenix\App\Deal\Tools\CreateTrainings;
use Beupsoft\Fenix\App\Deal\Tools\GenerateSchedule;
use Beupsoft\Fenix\App\Deal\Tools\UpdateTrainings;
use Beupsoft\Fenix\App\Training\TrainingDTO;

class PauseTrainingsAction
{
    private TrainingRepository $trainingRepository;
    private EventRepository $eventRepository;

    public function __construct(private readonly DealDTO $dealDTO)
    {
        $this->trainingRepository = new TrainingRepository();
        $this->eventRepository = new EventRepository();
    }

    public function execute(): void
    {
        if (
            $this->dealDTO->getStartDatePause()
            && $this->dealDTO->getEndDatePause()
        ) {
            $trainingsCollection = $this->getTrainings();

            # Close workouts that coincide with pause dates
            $trainingsToCloseCollection = $this->getTrainingsToClose($trainingsCollection);
            if (!empty($trainingsToCloseCollection)) {
                $this->closeTrainings($trainingsToCloseCollection);
                $this->deleteEvents($trainingsToCloseCollection);
            }

            # Calculation of the number of possible remaining workouts
            $trainingsActiveCollection = array_diff_key($trainingsCollection, $trainingsToCloseCollection);
            $trainingsActiveCollection = $this->getActiveTrainings($trainingsActiveCollection);
            $numberTrainings = $this->dealDTO->getNumberTrainings() - count($trainingsActiveCollection);

            # Find the last scheduled workout, or use the pause end date
            $startDate = $this->dealDTO->getEndDatePause();
            if (!empty($trainingsActiveCollection)) {
                $lastTrainingDTO = $this->getLastTraining($trainingsActiveCollection);
                if ($startDate->getTimestamp() < $lastTrainingDTO->getDatetimeTraining()->getTimestamp()) {
                    $startDate = $lastTrainingDTO->getDatetimeTraining();
                }
            }

            if ($numberTrainings > 0) {
                # Generate a new training schedule
                $trainingSchedule = $this->generateSchedule($startDate, $numberTrainings);


                if (!empty($trainingSchedule)) {
                    # Create trainings
                    $addedTrainingsCollection = $this->createTrainings($trainingSchedule);

                    # Get time statuses
                    $unavailableTime = $this->getUnavailableTime($addedTrainingsCollection);
                    $availableTime = array_diff_key($addedTrainingsCollection, $unavailableTime);

                    # Create events
                    if (!empty($availableTime)) {
                        $this->createEvents($availableTime);
                    }

                    # Set conflict status
                    if (!empty($unavailableTime)) {
                        $this->setConflictStatusForTrainings($unavailableTime);
                    }
                }
            }
        }
    }

    private function getTrainings(): array
    {
        return $this->trainingRepository->getTrainings($this->dealDTO->getId());
    }

    private function getTrainingsToClose(array $trainingsCollection): array
    {
        # Exclude stages
        if (!empty($trainingsCollection)) {
            $trainingsCollection = $this->excludeStages($trainingsCollection, ["DT149_30:FAIL", "DT149_30:SUCCESS"]);
        }

        # Exclude time
        if (!empty($trainingsCollection)) {
            $trainingsCollection = $this->excludeTime($trainingsCollection);
        }

        return $trainingsCollection;
    }

    private function excludeStages(array $trainingsCollection, array $stageExcluded): array
    {
        foreach ($trainingsCollection as $key => $trainingDTO) {
            if (in_array($trainingDTO->getStageId(), $stageExcluded)) {
                unset($trainingsCollection[$key]);
            }
        }

        return $trainingsCollection;
    }

    private function excludeTime(array $trainingsCollection): array
    {
        $startPause = $this->dealDTO->getStartDatePause();
        $endPause = $this->dealDTO->getEndDatePause();

        foreach ($trainingsCollection as $key => $trainingDTO) {
            $datetimeTraining = $trainingDTO->getDatetimeTraining();

            if ($datetimeTraining->getTimestamp() < $startPause->getTimestamp()
                || $datetimeTraining->getTimestamp() > $endPause->getTimestamp()) {
                unset($trainingsCollection[$key]);
            }
        }

        return $trainingsCollection;
    }

    private function closeTrainings(array $trainingsCollection): void
    {
        $handler = new UpdateTrainings();
        $handler->closeTrainings($trainingsCollection);
    }

    private function deleteEvents(array $trainingsCollection): void
    {
        $this->eventRepository->deleteEvents($trainingsCollection);
    }

    private function getActiveTrainings(array $trainingsCollection): array
    {
        return $this->excludeStages($trainingsCollection, ["DT149_30:FAIL"]);
    }

    private function getLastTraining(array $trainingsCollection): TrainingDTO
    {
        $lastTrainingDTO = null;

        foreach ($trainingsCollection as $key => $trainingDTO) {
            if ($trainingDTO->getDatetimeTraining() > $lastTrainingDTO?->getDatetimeTraining()) {
                $lastTrainingDTO = $trainingDTO;
            }
        }

        return $lastTrainingDTO;
    }

    private function generateSchedule(\DateTime $startDate, int $numberTrainings): array
    {
        $schedule = new GenerateSchedule(
            $startDate,
            $this->dealDTO->getDaysAndTime(),
            $numberTrainings
        );

        return $schedule->get();
    }

    private function createTrainings(array $datetimeCollection): array
    {
        $handler = new CreateTrainings($this->dealDTO);
        return $handler->execute($datetimeCollection);
    }

    private function getUnavailableTime(array $trainingsCollection): array
    {
        return $this->eventRepository->getUnavailableTime($trainingsCollection);
    }

    private function createEvents(array $trainingsCollection): void
    {
        $handler = new CreateEvents();
        $handler->createEvents($trainingsCollection);
    }

    private function setConflictStatusForTrainings(array $trainingsCollection): void
    {
        $handler = new UpdateTrainings();
        $handler->setConflictStatusForTrainings($trainingsCollection);
    }
}