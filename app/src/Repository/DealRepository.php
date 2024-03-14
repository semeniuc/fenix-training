<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\DealDTO;

# TODO: Настроить получение проверяемых полей и значений из конфига
class DealRepository
{
    public function get(int $dealId): DealDTO
    {
        $dealData = Bitrix::call("crm.item.get", [
            "entityTypeId" => 2,
            "id" => $dealId,
        ])["result"]["item"];

        return new DealDTO($dealData);
    }
}