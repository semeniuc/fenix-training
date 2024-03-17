<?php

namespace Beupsoft\Fenix\App\Deal;

use Beupsoft\Fenix\App\Deal\Actions\CreateTrainingsAction;

class DealController
{
    public function __construct(int $deadId)
    {
        $this->handle($deadId);
    }

    private function handle(int $dealId): void
    {
        $dealDTO = (new DealRepository())->get($dealId);


        if ($dealDTO->getCategoryId() == 6) {
            switch ($dealDTO->getStageId()) {
                case 'C6:PREPARATION': // Init
                    $createTrainings = new CreateTrainingsAction($dealDTO);
                    $createTrainings->execute();
                    break;
                case 'C6:PREPAYMENT_INVOICE': // Pause

                    break;
                default:
                    # code...
                    break;
            }
        }
    }
}
