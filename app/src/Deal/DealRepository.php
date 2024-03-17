<?php

namespace Beupsoft\Fenix\App\Deal;

use Beupsoft\App\Config\DealConfig;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Event\DealDTO;

class DealRepository
{
    public function get(int $dealId): DealDTO
    {
        $dealData = Bitrix::call("crm.item.get", [
            "entityTypeId" => DealConfig::getEntityTypeId(),
            "id" => $dealId,
        ])["result"]["item"];

        if ($dealData) {
            foreach (DealConfig::getFields() as $key => $field) {
                $data[$key] = $dealData[$field] ?? null;
            }
        }

        $data["daysAndTime"] = $this->getDaysAndTime($dealData);
        $data["numberTrainings"] = $this->getNumberTrainings($dealData);

        return new DealDTO($data);
    }

    private function getDaysAndTime(array $dealData): array
    {
        $response = [];

        $descValues = $this->geDescValues();
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
                    $response[$item["ID"]] = [
                        "day" => $listDays[$item["VALUE"]],
                        "time" => $time,
                    ];
                }
            }
        }

        return $response;
    }

    private function getNumberTrainings(array $dealData): ?int
    {
        $descValues = $this->geDescValues();
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

    private function geDescValues(): array
    {
        return Bitrix::call("crm.item.fields", [
            "entityTypeId" => DealConfig::getEntityTypeId(),
        ])["result"]["fields"];
    }
}