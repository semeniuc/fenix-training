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

    public function execute()
    {
        # TODO: Закрыть тренировки которые совпадают с паузой
        $this->closeTrainings();

        # TODO: Посчитать кол-во оставшихся тренировко
        # TODO: Сгенирировать новый график тренировок
        # TODO: Создать тренировки


    }

    private function closeTrainings()
    {
        $trainingsCollection = $this->trainingRepository->getTrainings($this->dealDTO->getId());
        dd($trainingsCollection);
    }
}