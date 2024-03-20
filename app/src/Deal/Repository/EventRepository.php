<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Repository;

use Beupsoft\App\Config\EventCalendarConfig;
use Beupsoft\App\Config\TrainingConfig;
use Beupsoft\Fenix\App\Bitrix;

class EventRepository
{
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

    public function deleteEvents(array $trainingsCollection): void
    {
        $arData = [];

        $ownerCalendar = EventCalendarConfig::getOwnerCalendar();
        foreach ($trainingsCollection as $trainingDTO) {
            if ($eventId = $trainingDTO->getEventId()) {
                $arData[$eventId] = [
                    "method" => "calendar.event.delete",
                    "params" => array_merge($ownerCalendar, [
                        "id" => $eventId,
                    ]),
                ];
            }
        }

        $batch = Bitrix::callBatch($arData)["result"]["result"] ?? [];

        dd(["deleteEvents" => $batch]);
    }
}