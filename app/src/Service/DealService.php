<?php

namespace Beupsoft\Fenix\App\Service;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Logging;
use Beupsoft\Fenix\App\DTO\DealDTO;

class DealService
{
     
    public function __construct()
    {
        # code...
    }

    public function handle(int $dealId): void
    {
        $deal = $this->getDealDTO($dealId);

        if($deal->getPipeline() == 6) {
            switch ($deal->getStage()) {
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

    private function getDealDTO(int $id): DealDTO
    {
        $dealData = Bitrix::call("crm.item.get", [
            "entityTypeId" => 2,
            "id" => $id,
        ])["result"]["item"];

        if ($dealData) {
            $dealDTO = (new DealDTO())
                ->setId($dealData["id"] ?? null)
                ->setPipeline($dealData["categoryId"] ?? null)
                ->setDays($dealData["ufCrm_1709801608762"] ?? null)
                ->setTime($dealData["ufCrm_1709801802210"] ?? null);
        } else {
            throw new Exception("Not found data for the deal: {$id}", 404);
        }

        return $dealDTO;
    }
}
