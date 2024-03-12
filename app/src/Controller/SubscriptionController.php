<?php

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Logging;
use Symfony\Component\Dotenv\Dotenv;

class SubscriptionController
{
    public function __construct()
    {
        while (!empty($events = $this->getEventsData())) {
            foreach ($events as $event) {
                switch ($event["EVENT_NAME"]) {
                    case "ONCRMDEALUPDATE":
                        # code...
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
                        Logging::save($events, "events", "listener");
                }
            }
            
        }
    }

    private function getEventsData(): array
    {
        $response = Bitrix::call("event.offline.get");
        return $response["result"]["events"] ?? [];
    }
}
