<?php

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\DealDTO;
use Beupsoft\Fenix\App\Logging;
use Exception;
use Symfony\Component\Dotenv\Dotenv;

class SubscriptionController
{
    public function __construct()
    {
        while (!empty($events = $this->getEventsData())) {
            foreach ($events as $event) {
                switch ($event["EVENT_NAME"]) {
                    case "ONCRMDEALUPDATE":
                        $deal = $this->getDealDTO($event["EVENT_DATA"]["FIELDS"]["ID"]);
                        break;
                    case "ONCRMDYNAMICITEMADD":
                        # code...
                        break;
                    case "ONCRMDYNAMICITEMUPDATE":
                        # code...
                        break;
                    case "ONCRMDYNAMICITEMDELETE":
                        # code...
                        break;
                    case "ONCALENDARENTRYUPDATE":
                        # code...
                        break;
                    case "ONCALENDARENTRYDELETE":
                        # code...
                        break;
                    default:
                        // Logging::save($events, "events", "listener");
                }
            }
            
        }
    }

    private function getEventsData(): array
    {
        $response = Bitrix::call("event.offline.get");
        return $response["result"]["events"] ?? [];
    }

    private function getDealDTO(int $id): DealDTO
    {
        $dealData = Bitrix::call("crm.item.get", [
            "entityTypeId" => 2,
            "id" => $id,
        ])["result"]["item"];

        if ($dealData) {
            $dealDTO = (new DealDTO())
            ->setId($dealData["id"] ?? null)
            ->setPipeline($dealData["categoryId"] ?? null)
            ->setDays($dealData["ufCrm_1709801608762"] ?? null)
            ->setTime($dealData["ufCrm_1709801802210"] ?? null);
        } else {
            throw new Exception("Not found data for the deal: {$id}", 404);
        }

        Logging::save($dealDTO, "dealDTO", "listener");

        return $dealDTO;
    }
}
