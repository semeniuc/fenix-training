<?php

namespace Beupsoft\Fenix\App\Deal;

use Beupsoft\Fenix\App\Deal\Actions\CreateTrainingsAction;
use Beupsoft\Fenix\App\Deal\Actions\PauseTrainingsAction;
use Beupsoft\Fenix\App\Deal\Repository\DealRepository;

class DealController
{
    public function __construct(int $deadId)
    {
        $this->handle($deadId);
    }

    private function handle(int $dealId): void
    {
        $dealDTO = (new DealRepository())->getDeal($dealId);

        if ($dealDTO->getCategoryId() == 6
            && $dealDTO->getStageId() !== $dealDTO->getLastStageAppLaunch()
        ) {
            switch ($dealDTO->getStageId()) {
                case 'C6:PREPARATION': // Init
                    $createTrainings = new CreateTrainingsAction($dealDTO);
                    $createTrainings->execute();
                    break;
                case 'C6:PREPAYMENT_INVOICE': // Pause
                    $pauseTrainings = new PauseTrainingsAction($dealDTO);
                    $pauseTrainings->execute();
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
