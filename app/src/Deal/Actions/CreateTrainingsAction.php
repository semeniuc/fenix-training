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
            $trainingsDto = $this->createTrainings($trainingSchedule);
        }

        dd([
            "trainingSchedule" => $trainingSchedule,
            "trainingsDto" => $trainingsDto,
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
                "assignedById" => $this->dealDTO->getAssignedById(),
                "datetimeTraining" => $datetime->format("Y-m-d H:i:s"),
                "dealId" => $this->dealDTO->getId(),
                "contactId" => $this->dealDTO->getContactId(),
            ];
        }
        
        return $this->dealRepository->createTrainings($data);
    }
}