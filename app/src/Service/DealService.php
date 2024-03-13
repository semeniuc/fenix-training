<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\DealDTO;
use Beupsoft\Fenix\App\Repository\DealRepository;
use Beupsoft\Fenix\App\Repository\TrainingRepository;

class DealService
{
    public function __construct()
    {
    }

    public function handle(int $dealId, string $eventType): void
    {
        $dealDTO = $this->getDeal($dealId);

        $categoryId = $dealDTO->getCategoryId();
        $stageId = $dealDTO->getStageId();

        if($categoryId == 6) {
            switch ($stageId) {
                case 'C6:PREPARATION': // Init
                    # code...
                    break;
                case 'C6:PREPAYMENT_INVOICE': // Pause
                    # code...
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    private function getDeal(int $dealId): DealDTO
    {
        $repository = new DealRepository();
        $deal = $repository->get($dealId);
        return $deal;
    } 

    private function getTrainingsByDeal(DealDTO $deal): array
    {
        $repository = new TrainingRepository();
        $trainingsDTO = $repository->findByDealId($deal->getId());

        return $trainingsDTO;
    }
}
