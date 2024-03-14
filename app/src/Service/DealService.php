<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\DealDTO;
use Beupsoft\Fenix\App\Repository\DealRepository;
use Beupsoft\Fenix\App\Repository\TrainingRepository;

class DealService
{
    private DealRepository $dealRepository;
    private TrainingRepository $trainingRepository;
    private EventCalendarService $eventCalendar;

    # TODO: Использовать кофиг вместо явных значений
    public function __construct()
    {
        $this->dealRepository = new DealRepository();
        $this->trainingRepository = new TrainingRepository();
        $this->eventCalendar = new EventCalendarService();
    }

    public function handle(int $dealId): void
    {
        $dealDTO = $this->getDeal($dealId);

        $categoryId = $dealDTO->getCategoryId();
        $stageId = $dealDTO->getStageId();

        if($categoryId == 6) {

//            $trainings = $this->getTrainingsByDeal($dealDTO);
//            dd($dealDTO);
            $this->createTrainings($dealDTO);

//            switch ($stageId) {
//                case 'C6:PREPARATION': // Init
//                    # code...
//                    break;
//                case 'C6:PREPAYMENT_INVOICE': // Pause
//
//                    break;
//                default:
//                    # code...
//                    break;
//            }
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
        $trainingSchedule = $this->getTrainingSchedule($dealDTO->getStartDate(), $dealDTO->getDaysAndTime(), $dealDTO->getNumberTrainings());
        dd($trainingSchedule);
    }

    private function getTrainingSchedule(\DateTime $startDate, array $daysAndTime, int $numberTrainings): array
    {
        $data = [];

        $count = 0;
        $weekOffset = 0;
        while ($count < $numberTrainings) {
            foreach ($daysAndTime as $key => $value) {
                $dayOfWeek = $value['day'];
                $time = $value['time'];

                $trainingDate = clone $startDate;
                $trainingDate->modify("+" . ($weekOffset * 7 + $dayOfWeek - 1) . " days");

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
