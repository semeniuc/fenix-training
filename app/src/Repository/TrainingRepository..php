<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\TrainingDTO;

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

    public function findTrainingsByDealId(int $dealId)
    {
        $trainingsData = Bitrix::call("crm.item.list", [
            "entityTypeId" => 149,
            // "filter" => [

            // ], 
        ]);

        return $trainingsData;
    }
}