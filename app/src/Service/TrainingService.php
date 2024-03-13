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
        $repository = new TrainingRepository();
        $training = $repository->get($trainingId);
        return $training;
    }

    private getEventCalendar(int $eventId): EventCalendarDTO
    {
        $event = new EventCalendarDTO();
    }
}
