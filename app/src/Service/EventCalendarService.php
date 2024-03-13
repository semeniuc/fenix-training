<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\DTO\DealDTO;
use Beupsoft\Fenix\App\Repository\DealRepository;
use Beupsoft\Fenix\App\Repository\TrainingRepository;

class EventCalendarService
{
    private DealDTO $dealDTO;
    private array $trainingsDTO;

    public function __construct(int $eventId)
    {
        $this->dealDTO = $this->getDeal($dealId);
        $this->trainingsDTO = $this->getTrainingsByDeal($this->dealDTO);

        dd($this->trainingsDTO);
    }

    public function handle(): void
    {
        if($this->dealDTO->getCategoryId() == 6) {
            switch ($this->dealDTO->getStageId()) {
                case 'C6:PREPARATION':
                    # code...
                    break;
                case 'C6:PREPAYMENT_INVOICE':
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
