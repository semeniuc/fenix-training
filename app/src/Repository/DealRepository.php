<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\DealDTO;

# TODO: Настроить получение проверяемых полей и значений из конфига
class DealRepository
{
    public function findByDealId(int $dealId): DealDTO
    {
        $dealData = Bitrix::call("crm.item.get", [
            "entityTypeId" => 2,
            "id" => $dealId,
        ])["result"]["item"];

        if ($dealData) {
            $dealDTO = (new DealDTO())
            ->setId($dealData["id"] ?? null)
            ->setPipeline($dealData["categoryId"] ?? null)
            ->setDays($dealData["ufCrm_1709801608762"] ?? null)
            ->setTime($dealData["ufCrm_1709801802210"] ?? null);
        } else {
            throw new Exception("Not found data for the deal: {$dealId}", 404);
        }

        return $dealDTO;
    }
}