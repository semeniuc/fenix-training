<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Tools;

use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;

class UpdateTrainings
{
    private TrainingRepository $trainingRepository;

    public function __construct()
    {
        $this->trainingRepository = new TrainingRepository();
    }

    public function closeTrainings(array $trainingsCollection): void
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

    public function setConflictStatusForTrainings(array $trainingsCollection): void
    {
        $data = [];
        foreach ($trainingsCollection as $trainingDto) {
            $trainingId = $trainingDto->getId();

            $data[] = [
                "id" => $trainingId,
                "fields" => [
                    "stageId" => "DT149_30:PREPARATION",
                ],
            ];
        }

        $this->trainingRepository->updateTrainings($data);
    }
}