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

    public function handle(TrainingDTO $trainingDTO, string $command): void
    {
        switch ($command) {
            case 'add':
                # code...
                break;
            case 'upd':
                # code...
                break;
            case 'del':
                # code...
                break;
        }
    }

    public function getTraining(int $trainingId): TrainingDTO
    {
        return $this->trainingRepository->get($trainingId);
    }

    
}
