<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\TrainingDTO;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;

class TrainingService
{
    private TrainingDTO $trainingsDTO;

    public function __construct(int $trainingId)
    {
        $this->trainingRepository = new TrainingRepository();
        $this->eventCalendarRepository = new EventCalendarRepository();

        $this->trainingsDTO = $this->getTraining($trainingId);
        

        dd($this->trainingsDTO);
    }

    public function handle(string $command): void
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

    private function getTraining(int $trainingId): TrainingDTO
    {
        return $this->trainingRepository->get($trainingId);
    }

    
}
