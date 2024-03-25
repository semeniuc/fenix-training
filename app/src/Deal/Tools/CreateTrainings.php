<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Tools;

use Beupsoft\Fenix\App\Deal\DealDTO;
use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;

class CreateTrainings
{
    private TrainingRepository $trainingRepository;

    public function __construct(private readonly DealDTO $dealDTO)
    {
        $this->trainingRepository = new TrainingRepository();
    }

    public function execute(array $datetimeCollection): array
    {
        $data = [];
        foreach ($datetimeCollection as $datetime) {
            $data[] = [
                "title" => $this->dealDTO->getTitle(),
                "assignedById" => $this->dealDTO->getAssignedById(),
                "datetimeTraining" => $datetime->format("Y-m-d H:i:s"),
                "dealId" => $this->dealDTO->getId(),
                "contactId" => $this->dealDTO->getContactId(),
            ];
        }

        return $this->trainingRepository->createTrainings($data);
    }
}