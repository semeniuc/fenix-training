<?php

namespace Beupsoft\Fenix\App;

use Beupsoft\Fenix\App\Deal\DealController;
use Beupsoft\Fenix\App\Training\TrainingService;

class Listener
{
    public function __construct()
    {
        while (!empty($events = $this->getEventsData())) {
            foreach ($events as $event) {
                try {
                    if (!isset($event["EVENT_DATA"]["FIELDS"]["ID"])) {
                        continue;
                    }

                    $elementId = $event["EVENT_DATA"]["FIELDS"]["ID"];

                    if (!empty($elementId)) {
                        switch ($event["EVENT_NAME"]) {
                            case "ONCRMDEALUPDATE":
                                new DealController($elementId);
                                break;
                            case "ONCRMDYNAMICITEMUPDATE_149":
                            case "ONCRMDYNAMICITEMADD_149":
                                (new TrainingService())->handle($elementId);
                                break;
                            case "ONCALENDARENTRYDELETE":
                            case "ONCALENDARENTRYUPDATE":
                                # code...
                                break;
                            default:
                                break;
                        }
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

            sleep(2);
        }
    }

    private function getEventsData(): array
    {
        return Bitrix::call("event.offline.get")["result"]["events"] ?? [];
    }
}
