<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Actions;

use Beupsoft\Fenix\App\Deal\DealDTO;
use Beupsoft\Fenix\App\Deal\Repository\EventRepository;
use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;
use Beupsoft\Fenix\App\Deal\Tools\GenerateSchedule;
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
            # TODO: Закрыть тренировки которые совпадают с паузой
            $trainingsCollection = $this->getTrainings();

            $trainingsToCloseCollection = $this->getTrainingsToClose($trainingsCollection);
            if (!empty($trainingsToCloseCollection)) {
                $this->closeTrainings($trainingsToCloseCollection);
                $this->deleteEvents($trainingsToCloseCollection);
            }

            # TODO: Посчитать кол-во возможных оставшихся тренировок
            $trainingsActiveCollection = array_diff_key($trainingsCollection, $trainingsToCloseCollection);
            $trainingsActiveCollection = $this->getActiveTrainings($trainingsActiveCollection);
            $numberTrainings = $this->dealDTO->getNumberTrainings() - count($trainingsActiveCollection);

            # TODO: Найти последнюю запланированную тренировку, либо использовать дату окончания паузы
            $startDate = $this->dealDTO->getEndDatePause();
            if (!empty($trainingsActiveCollection)) {
                $lastTrainingDTO = $this->getLastTraining($trainingsActiveCollection);
                if ($startDate->getTimestamp() < $lastTrainingDTO->getDatetimeTraining()->getTimestamp()) {
                    $startDate = $lastTrainingDTO->getDatetimeTraining();
                }
            }

            if ($numberTrainings > 0) {
                # TODO: Сгенирировать новый график тренировок
                $trainingSchedule = $this->generateSchedule($startDate, $numberTrainings);
                # TODO: Создать тренировки
            }

            dd([
                "numberTrainings" => $numberTrainings,
                "trainingSchedule" => $trainingSchedule ?? null,
                "trainingsCollection" => $trainingsCollection,
                "trainingsToCloseCollection" => $trainingsToCloseCollection,
                "trainingsActiveCollection" => $trainingsActiveCollection,
            ]);
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
        $data = [];
        foreach ($trainingsCollection as $trainingDto) {
            $trainingId = $trainingDto->getId();

            $data[$trainingId] = [
                "id" => $trainingId,
                "fields" => [
                    "stageId" => "DT149_30:FAIL",
                    "eventId" => "",
                    "whoIsClosed" => 484,
                ],
            ];
        }

        $this->trainingRepository->updateTrainings($data);
    }

    private function deleteEvents(array $trainingsCollection): void
    {
        $this->eventRepository->deleteEvents($trainingsCollection);
    }

    private function getActiveTrainings(array $trainingsCollection)
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
}