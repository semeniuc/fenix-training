<?php

namespace Beupsoft\Fenix\App\Deal\Repository;

use Beupsoft\App\Config\DealConfig;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Deal\DealDTO;

class DealRepository
{
    public function getDeal(int $dealId): ?DealDTO
    {
        $dealData = Bitrix::call("crm.item.get", [
            "entityTypeId" => DealConfig::getEntityTypeId(),
            "id" => $dealId,
        ])["result"]["item"];

        if ($dealData) {
            foreach (DealConfig::getFields() as $key => $field) {
                $data[$key] = $dealData[$field] ?? null;
            }

            $descValues = $this->getDescValues();

            $data["daysAndTime"] = $this->getDaysAndTime($dealData, $descValues);
            $data["numberTrainings"] = $this->getNumberTrainings($dealData, $descValues);

            return new DealDTO($data);
        }

        return null;
    }

    public function updateDeal(int $dealId, array $data)
    {
        $fields = DealConfig::getFields();

        $post = [];
        foreach ($data as $key => $value) {
            $post[$fields[$key]] = $value;
        }

        Bitrix::call("crm.item.update", [
            "entityTypeId" => DealConfig::getEntityTypeId(),
            "id" => $dealId,
            "fields" => $post,
        ])["result"]["item"];
    }

    private function getDaysAndTime(array $dealData, array $descValues): array
    {
        $response = [];

        $dealConfig = DealConfig::getFields();
        $listDays = DealConfig::getListDays();


        if ($descValues && $dealConfig) {
            // Get time
            $timeId = $dealData[$dealConfig["time"]];
            $timeValues = $descValues[$dealConfig["time"]]["items"];
            $time = "";

            foreach ($timeValues as $item) {
                if ($item["ID"] == $timeId) {
                    $time = $item["VALUE"];
                    break;
                }
            }

            // Get days
            $daysIds = $dealData[$dealConfig["days"]];
            $daysValues = $descValues[$dealConfig["days"]]["items"];

            foreach ($daysValues as $item) {
                if (in_array($item["ID"], $daysIds)) {
                    $response[$listDays[$item["VALUE"]]] = [
                        "id" => $item["ID"],
                        "time" => $time,
                    ];
                }
            }
        }

        return $response;
    }

    private function getNumberTrainings(array $dealData, array $descValues): ?int
    {
        $dealConfig = DealConfig::getFields();

        if ($descValues && $dealConfig) {
            // Get number of trainings
            $numberId = $dealData[$dealConfig["numberTrainings"]];
            $numberTrainingValues = $descValues[$dealConfig["numberTrainings"]]["items"];

            foreach ($numberTrainingValues as $item) {
                if ($item["ID"] == $numberId) {
                    return $item["VALUE"];
                }
            }
        }

        return null;
    }

    private function getDescValues(): array
    {
        return Bitrix::call("crm.item.fields", [
            "entityTypeId" => DealConfig::getEntityTypeId(),
        ])["result"]["fields"];
    }
}