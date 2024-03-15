<?php 

namespace Beupsoft\Fenix\App\Repository;

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\App\Config\TrainingConfig;
use Beupsoft\Fenix\App\DTO\TrainingDTO;

class TrainingRepository
{
    public function add(array $data)
    {
        $trainingData = Bitrix::call("crm.item.add", [
            "entityTypeId" => TrainingConfig::getEntityTypeId(),
            "fields" => $data
        ])["result"]["item"];

        dd($trainingData);
    }

    public function get(int $trainingId): TrainingDTO
    {
        $trainingData = Bitrix::call("crm.item.get", [
            "entityTypeId" => TrainingConfig::getEntityTypeId(),
            "id" => $trainingId,
        ])["result"]["item"];

        $data = [];
        if ($trainingData) {
            foreach (TrainingConfig::getFields() as $key => $field) {
                $data[$key] = $trainingData[$field] ?? null;
            }
        }

        return new TrainingDTO($data);
    }

    public function upd(int $trainingId, array $data): bool 
    {
        $trainingData = Bitrix::call("crm.item.update", [
            "entityTypeId" => TrainingConfig::getEntityTypeId(),
            "id" => $trainingId,
            "fields" => $data,
        ])["result"]["item"] ?? null;

        return (!empty($trainingData));
    }

    public function findByDealId(int $dealId): array
    {
        $trainingsDTO = [];

        $trainingsData = Bitrix::call("crm.item.list", [
            "entityTypeId" => TrainingConfig::getEntityTypeId(),
            "filter" => [
                "parentId2" => $dealId
            ], 
        ])["result"]["items"];

        if (!empty($trainingsData)) {
            foreach ($trainingsData as $trainingData) {

                $data = [];
                if ($trainingData) {
                    foreach (TrainingConfig::getFields() as $key => $field) {
                        $data[$key] = $trainingData[$field] ?? null;
                    }
                }

                $dto = new TrainingDTO($data);
                
                if ($dto->getId() !== null) {
                    $trainingsDTO[] = $dto;
                }
            }
        }

        return $trainingsDTO;
    }
}