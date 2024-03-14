<?php

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Logging;
use Beupsoft\Fenix\App\Service\DealService;
use Beupsoft\Fenix\App\Service\TrainingService;

class SubscriptionController
{
    public function __construct()
    {
        while (!empty($events = $this->getEventsData())) {
            foreach ($events as $event) {
                switch ($event["EVENT_NAME"]) {
                    case "ONCRMDEALUPDATE":
                        (new DealService())->handle($event["EVENT_DATA"]["FIELDS"]["ID"]);
                        break;
                    case "ONCRMDYNAMICITEMADD_149":
                        (new TrainingService())->handle($event["EVENT_DATA"]["FIELDS"]["ID"]);
                        break;
                    case "ONCRMDYNAMICITEMUPDATE_149":
                        (new TrainingService())->handle($event["EVENT_DATA"]["FIELDS"]["ID"]);
                        break;
                    case "ONCALENDARENTRYUPDATE":
                        # code...
                        break;
                    case "ONCALENDARENTRYDELETE":
                        # code...
                        break;
                    default:
                        break;
                }
            }

            Logging::save($events, "events", "listener");
        }
    }

    private function getEventsData(): array
    {
        $response = Bitrix::call("event.offline.get");
        return $response["result"]["events"] ?? [];
    }
}
