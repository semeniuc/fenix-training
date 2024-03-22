<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Actions;

use Beupsoft\Fenix\App\Deal\DealDTO;
use Beupsoft\Fenix\App\Deal\Repository\DealRepository;
use Beupsoft\Fenix\App\Deal\Repository\EventRepository;
use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;

class PauseTrainingsAction
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

    public function execute(): void
    {
        if (
            $this->dealDTO->getStartDatePause()
            && $this->dealDTO->getEndDatePause()
        ) {
            # TODO: Закрыть тренировки которые совпадают с паузой
            $trainingsCollection = $this->getTrainingsToClose();

            dd($trainingsCollection);

            if (!empty($trainingsCollection)) {
                $this->closeTrainings($trainingsCollection);
                $this->deleteEvents($trainingsCollection);
            }


            # TODO: Посчитать кол-во оставшихся тренировок
            # TODO: Найти последнюю запланированную тренировку, либо использовать дату окончания паузы
            # TODO: Сгенирировать новый график тренировок
            # TODO: Создать тренировки
        }
    }

    private function getTrainingsToClose(): array
    {
        $trainingsCollection = $this->trainingRepository->getTrainings($this->dealDTO->getId());

        # Exclude stages
        if (!empty($trainingsCollection)) {
            $trainingsCollection = $this->excludeStages($trainingsCollection);
        }

        # Exclude time
        if (!empty($trainingsCollection)) {
            $trainingsCollection = $this->excludeTime($trainingsCollection);
        }

        return $trainingsCollection;
    }

    private function excludeStages(array $trainingsCollection): array
    {
        $stageExcluded = [
            "DT149_30:FAIL",
            "DT149_30:SUCCESS"
        ];

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

            if (($datetimeTraining >= $startPause && $datetimeTraining <= $endPause) !== true) {
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
                    "ufCrm22EventId" => "",
                ],
            ];
        }

        $this->trainingRepository->updateTrainings($data);
    }

    private function deleteEvents(array $trainingsCollection): void
    {
        $this->eventRepository->deleteEvents($trainingsCollection);
    }
}