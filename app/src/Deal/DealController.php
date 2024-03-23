<?php

namespace Beupsoft\Fenix\App\Deal;

use Beupsoft\Fenix\App\Deal\Actions\CreateTrainingsAction;
use Beupsoft\Fenix\App\Deal\Actions\PauseTrainingsAction;
use Beupsoft\Fenix\App\Deal\Repository\DealRepository;

class DealController
{
    private DealRepository $dealRepository;
    private DealDTO $dealDTO;

    public function __construct(int $dealId)
    {
        $this->dealRepository = new DealRepository();
        $this->dealDTO = $this->dealRepository->getDeal($dealId);
        $this->handle();
    }

    private function handle(): void
    {
        if ($this->dealDTO->getCategoryId() == 6
            && $this->dealDTO->getStageId() !== $this->dealDTO->getLastStageAppLaunch()
        ) {
            switch ($this->dealDTO->getStageId()) {
                case 'C6:PREPARATION': // Init
                    $createTrainings = new CreateTrainingsAction($this->dealDTO);
                    $createTrainings->execute();
                    $this->updLastStageAppLaunch();
                    break;
                case 'C6:PREPAYMENT_INVOICE': // Pause
                    $pauseTrainings = new PauseTrainingsAction($this->dealDTO);
                    $pauseTrainings->execute();
                    $this->updLastStageAppLaunch();
                    break;
                default:
                    # code...
                    break;
            }
        }
    }

    private function updLastStageAppLaunch(): void
    {
        $this->dealRepository->updateDeal($this->dealDTO->getId(), [
            "lastStageAppLaunch" => $this->dealDTO->getStageId(),
        ]);
    }
}
