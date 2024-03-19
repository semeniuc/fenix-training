<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Repository;

use Beupsoft\App\Config\TrainingConfig;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Training\TrainingDTO;

class TrainingRepository
{
    /**
     * @param array $data fields for trainings
     * @return array training ids
     */
    public function createTrainings(array $data): array
    {
        $arData = [];
        $entityTypeId = TrainingConfig::getEntityTypeId();
        $fields = TrainingConfig::getFields();

        foreach ($data as $item) {
            $post = [];
            foreach ($item as $key => $value) {
                if (isset($fields[$key])) {
                    $post[$fields[$key]] = $value;
                }
            }

            $arData[] = [
                "method" => "crm.item.add",
                "params" => [
                    "entityTypeId" => $entityTypeId,
                    "fields" => $post,
                ],
            ];
        }

        $batch = Bitrix::callBatch($arData)["result"]["result"] ?? [];

        $trainingCollection = [];
        if (!empty($batch)) {
            foreach ($batch as $record) {
                if (isset($record["item"]["id"])) {
                    $data = [];
                    foreach ($fields as $key => $field) {
                        $data[$key] = $record["item"][$field] ?? null;
                    }

                    $trainingDto = new TrainingDTO($data);
                    $trainingCollection[$trainingDto->getId()] = $trainingDto;
                }
            }
        }

        return $trainingCollection;
    }

    public function updateTrainings(array $data): void
    {
        $arData = [];
        $entityTypeId = TrainingConfig::getEntityTypeId();
        $fields = TrainingConfig::getFields();

        foreach ($data as $item) {
            $post = [];
            foreach ($item["fields"] as $key => $value) {
                if (isset($fields[$key])) {
                    $post[$fields[$key]] = $value;
                }
            }

            $arData[] = [
                "method" => "crm.item.update",
                "params" => [
                    "entityTypeId" => $entityTypeId,
                    "id" => $item["id"],
                    "fields" => $post,
                ],
            ];
        }

        $batch = Bitrix::callBatch($arData)["result"]["result"] ?? [];
    }

    public function getTrainings(int $dealId): array
    {
        $trainingCollection = [];
        $entityTypeId = TrainingConfig::getEntityTypeId();
        $fields = TrainingConfig::getFields();

        $trainingsData = Bitrix::call("crm.item.list", [
            "entityTypeId" => $entityTypeId,
            "filter" => [
                "parentId2" => $dealId,
            ],
        ])["result"]["items"];

        if (!empty($trainingsData)) {
            foreach ($trainingsData as $record) {
                if (isset($record["id"])) {
                    $data = [];
                    foreach ($fields as $key => $field) {
                        $data[$key] = $record[$field] ?? null;
                    }

                    $trainingDto = new TrainingDTO($data);
                    $trainingCollection[$trainingDto->getId()] = $trainingDto;
                }
            }
        }

        return $trainingCollection;
    }
}