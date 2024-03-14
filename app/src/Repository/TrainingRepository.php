<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use DateTime;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\TrainingDTO;

# TODO: Настроить получение проверяемых полей и значений из конфига
class TrainingRepository
{
    public function add(object $dto) 
    {

    }

    public function get(int $trainingId): TrainingDTO
    {
        $trainingData = Bitrix::call("crm.item.get", [
            "entityTypeId" => 149,
            "id" => $trainingId,
        ])["result"]["item"];

        return new TrainingDTO($trainingData);
    }

    public function upd(int $trainingId, array $data): bool 
    {
        $trainingData = Bitrix::call("crm.item.update", [
            "entityTypeId" => 149,
            "id" => $trainingId,
            "fields" => $data,
        ])["result"]["item"] ?? null;

        return (!empty($trainingData));
    }

    public function findByDealId(int $dealId): array
    {
        $trainingsDTO = [];

        $trainingsData = Bitrix::call("crm.item.list", [
            "entityTypeId" => 149,
            "filter" => [
                "parentId2" => $dealId
            ], 
        ])["result"]["items"];

        if (!empty($trainingsData)) {
            foreach ($trainingsData as $training) {
                $datetimeTraining = (!empty($training['ufCrm22_1709804621873'])) ? new DateTime($training['ufCrm22_1709804621873']) : null;

                $dto = new TrainingDTO($training);
                
                if ($dto->getId() !== null) {
                    $trainingsDTO[] = $dto;
                }
            }
        }

        return $trainingsDTO;
    }
}