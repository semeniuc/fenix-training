<?php

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\Logging;
use Symfony\Component\Dotenv\Dotenv;

class SubscriptionController
{
    public function __construct()
    {
        // dd(["index"]);
        // $dotenv = new Dotenv();
        // $dotenv->load(dirname(__DIR__, 2) . '/.env');

        // Logging::save($_REQUEST, 'listener');

        while (!empty($events = $this->getEventsData())) {
            foreach ($events as $event) {
                switch ($event["EVENT_NAME"]) {
                    case "ONCRMDYNAMICITEMADD":
                        # code...
                        break;
                    case "ONCRMDYNAMICITEMUPDATE":
                        # code...
                        break;
                    case "ONCRMDYNAMICITEMDELETE":
                        # code...
                        break;
                    case "ONCALENDARENTRYADD":
                        # code...
                        break;
                    case "ONCALENDARENTRYUPDATE":
                        # code...
                        break;
                    case "ONCALENDARENTRYDELETE":
                        # code...
                        break;
                }
            }
            Logging::save($events, "events");
        }
    }

    private function getEventsData(): array
    {
        $response = Bitrix::call("event.offline.get");
        return $response["result"]["events"] ?? [];
    }
}
