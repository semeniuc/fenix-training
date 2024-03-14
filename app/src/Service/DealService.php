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
            dd($dealDTO);

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

    private function getTrainingsByDeal(DealDTO $deal): array
    {
        return $this->trainingRepository->findByDealId($deal->getId());
    }

    private function createTrainings() {

    }
}
