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
                    try {
                        switch ($event["EVENT_NAME"]) {
                            case "ONCRMDEALUPDATE":
                                (new DealService())->handle($event["EVENT_DATA"]["FIELDS"]["ID"]);
                                break;
                            case "ONCRMDYNAMICITEMUPDATE_149":
                            case "ONCRMDYNAMICITEMADD_149":
                                (new TrainingService())->handle($event["EVENT_DATA"]["FIELDS"]["ID"]);
                                break;
                            case "ONCALENDARENTRYDELETE":
                            case "ONCALENDARENTRYUPDATE":
                                # code...
                                break;
                            default:
                                break;
                        }
                    } catch (\Throwable $th) {
                        Logging::save(
                            [
                                "code" => $th->getCode(),
                                "message" => $th->getMessage(),
                                "file" => $th->getFile(),
                                "line" => $th->getLine()
                            ],
                            "throwable",
                            "error"
                        );
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
