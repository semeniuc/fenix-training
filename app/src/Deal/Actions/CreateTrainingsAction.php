<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Actions;

use Beupsoft\App\Config\TrainingConfig;
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
        $fields = TrainingConfig::getFields();

        $data = [];
        foreach ($datetimeCollection as $datetime) {
            $data[] = [
                $fields["assignedById"] => $this->dealDTO->getAssignedById(),
                $fields["datetimeTraining"] => $datetime->format("Y-m-d H:i:s"),
                $fields["dealId"] => $this->dealDTO->getId(),
                $fields["contactId"] => $this->dealDTO->getContactId(),
            ];
        }

        return $this->dealRepository->addTranings($data);
    }
}