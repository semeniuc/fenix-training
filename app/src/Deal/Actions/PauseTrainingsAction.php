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

            if (!empty($trainingsCollection)) {
                $this->closeTrainings($trainingsCollection);
                $this->deleteEvents($trainingsCollection);
            }


            # TODO: Посчитать кол-во оставшихся тренировко
            # TODO: Сгенирировать новый график тренировок
            # TODO: Создать тренировки
        }
    }

    private function getTrainingsToClose(): array
    {
        return $this->trainingRepository->getTrainings($this->dealDTO->getId());
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