<?php

namespace Beupsoft\Fenix\App\Deal;

use Beupsoft\App\Config\DealConfig;
use Beupsoft\App\Config\EventCalendarConfig;
use Beupsoft\App\Config\TrainingConfig;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Training\TrainingDTO;

class DealRepository
{
    public function get(int $dealId): ?DealDTO
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

    public function updateTrainings(array $data)
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

        dd(["arData" => $arData, "data" => $data, "batch" => $batch]);
    }

    public function getUnavailableTime(array $trainingsCollection): array
    {
        $timeNotAvailable = [];
        $entityTypeId = TrainingConfig::getEntityTypeId();

        $arData = [];
        foreach ($trainingsCollection as $trainingDto) {
            $arData[$trainingDto->getId()] = [
                "method" => "calendar.accessibility.get",
                "params" => [
                    "users" => [$trainingDto->getAssignedById()],
                    "from" => $trainingDto->getDatetimeTraining()->format("Y-m-d H:i:s"),
                    "to" => $trainingDto->getDatetimeTraining()->modify("+1 hour")->format("Y-m-d H:i:s"),
                ],
            ];
        }

        $batch = Bitrix::callBatch($arData)["result"]["result"] ?? [];

        if (!empty($batch)) {
            foreach ($batch as $trainingId => $userIds) {
                foreach ($userIds as $value) {
                    if (!empty($value)) {
                        $timeNotAvailable[$trainingId] = $trainingsCollection[$trainingId];
                    }
                }
            }
        }

        return $timeNotAvailable;
    }

    public function createEvents(array $trainingsCollection): array
    {
        $arData = [];

        $ownerCalendar = EventCalendarConfig::getOwnerCalendar();
        foreach ($trainingsCollection as $trainingDTO) {
            $trainingId = $trainingDTO->getId();
            $title = $trainingDTO->getTitle();
            $assignedById = $trainingDTO->getAssignedById();

            $datetime = $trainingDTO->getDatetimeTraining();
            $from = ($datetime) ? $datetime->format("Y-m-d H:i:s") : null;
            $to = ($datetime) ? $datetime->modify("+1 hour")->format("Y-m-d H:i:s") : null;

            $arData[$trainingId] = [
                "method" => "calendar.event.add",
                "params" => array_merge($ownerCalendar, [
                    "accessibility" => "busy",
                    "from" => $from,
                    "to" => $to,
                    "name" => $title,
                    "description" => "<b><a href=\"https://fenixtraining.bitrix24.pl/page/trenerzy/treningi/type/149/details/{$trainingId}/\">EDYTUJ TRENING</a></b>",
                    "is_meeting" => "Y",
                    "location" => "",
                    "attendees" => [$assignedById],
                    "color" => "#9cbe1c",
                    "text_color" => "#283033",
                ]),
            ];
        }

        $batch = Bitrix::callBatch($arData)["result"]["result"] ?? [];

        return $batch;
    }
}