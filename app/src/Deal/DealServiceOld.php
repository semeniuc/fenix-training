<?php

namespace Beupsoft\Fenix\App\Deal;

use Beupsoft\Fenix\App\Event\DealDTO;
use Beupsoft\Fenix\App\Repository\DealRepository;
use Beupsoft\Fenix\App\Training\TrainingRepository;
use Beupsoft\Fenix\App\Training\TrainingService;

class DealServiceOld
{
    private DealRepository $dealRepository;
    private TrainingRepository $trainingRepository;
    private TrainingService $trainingService;

    # TODO: Использовать кофиг вместо явных значений
    public function __construct()
    {
        $this->dealRepository = new DealRepository();
        $this->trainingRepository = new TrainingRepository();
        $this->trainingService = new TrainingService();
    }

    public function handle(int $dealId): void
    {
        $dealDTO = $this->getDeal($dealId);

        $categoryId = $dealDTO->getCategoryId();
        $stageId = $dealDTO->getStageId();

        if ($categoryId == 6) {
            $this->createTrainings($dealDTO);
            switch ($stageId) {
                case 'C6:PREPARATION': // Init
                    if (empty($this->getTrainingsByDeal($dealDTO->getId()))) {
                        $this->createTrainings($dealDTO);
                    }
                    break;
                case 'C6:PREPAYMENT_INVOICE': // Pause

                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    public function getDeal(int $dealId): DealDTO
    {
        return $this->dealRepository->get($dealId);
    }

    private function getTrainingsByDeal(int $dealId): array
    {
        return $this->trainingRepository->findByDealId($dealId);
    }

    private function createTrainings(DealDTO $dealDTO)
    {
        $trainingSchedule = $this->getTrainingSchedule(
            $dealDTO->getStartDate(),
            $dealDTO->getDaysAndTime(),
            $dealDTO->getNumberTrainings()
        );

        if ($trainingSchedule) {
            foreach ($trainingSchedule as $date) {
                $trainingId = $this->trainingRepository->add([
                    "title" => "test",
                    "assignedById" => $dealDTO->getAssignedById(),
                    "ufCrm22_1709804621873" => $date->format("Y-m-d H:i:s"),
                    "parentId2" => $dealDTO->getId(),
                    "contactId" => $dealDTO->getContactId(),
                ]);

                $this->trainingService->handle($trainingId);
            }
        }
    }

    private function getTrainingSchedule(\DateTime $startDate, array $daysAndTime, int $numberTrainings): array
    {
        $data = [];

        // Determine the date of the first training
        $firstDay = min(array_column($daysAndTime, 'day'));
        $firstTrainingDate = clone $startDate;
        $firstTrainingDate->modify("next Monday");

        $currentDate = new \DateTime();
        while (
            $firstTrainingDate->format("N") != $firstDay
            && $firstTrainingDate < $startDate
            && $firstTrainingDate < $currentDate
        ) {
            $firstTrainingDate->modify("+1 day");
        }

        // Get dates
        $count = 0;
        $weekOffset = 0;
        while ($count < $numberTrainings) {
            foreach ($daysAndTime as $key => $value) {
                $dayOfWeek = $value['day'];

                // Set date
                $trainingDate = clone $firstTrainingDate;
                $trainingDate->modify("+" . ($weekOffset * 7 + $dayOfWeek - 1) . " days");

                // Set time
                $time = $value['time'];
                $timeParts = explode(':', $time);
                $trainingDate->setTime((int)$timeParts[0], (int)$timeParts[1]);

                // Save
                $data[] = $trainingDate;

                $count++;
                if ($count >= $numberTrainings) {
                    break;
                }
            }
            $weekOffset++;
        }

        return $data;
    }
}
