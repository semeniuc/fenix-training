<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\TrainingDTO;

# TODO: Настроить получение проверяемых полей и значений из конфига
class TrainingRepository
{
    public function __construct()
    {
        # code...
    }

    public function add(object $dto) 
    {

    }

    // public function get(int $trainingId): TrainingDTO
    // {
    //     $trainingData = Bitrix::call("crm.item.get", [
    //         "entityTypeId" => 2,
    //         "id" => $dealId,
    //     ])["result"]["item"];
    // }

    public function upd(int $id, object $dto) 
    {

    }

    public function findTrainingsByDealId(int $dealId): array
    {
        $trainingsDTO = [];

        $trainingsData = Bitrix::call("crm.item.list", [
            "entityTypeId" => 149,
            "filter" => [
                "parentId2" => $dealId
            ], 
        ])["result"]["items"];

        // if ($trainingsData) {
        //     $dealDTO = (new TrainingDTO())
        //     ->setId($dealData["id"] ?? null)
        //     ->setPipeline($dealData["categoryId"] ?? null)
        //     ->setDays($dealData["ufCrm_1709801608762"] ?? null)
        //     ->setTime($dealData["ufCrm_1709801802210"] ?? null);
        // } else {
        //     throw new Exception("Not found data for the deal: {$dealId}", 404);
        // }

        return $trainingsData;
    }
}