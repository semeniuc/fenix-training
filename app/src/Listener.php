<?php

namespace Beupsoft\Fenix\App;

use Beupsoft\Fenix\App\Deal\DealController;

class Listener
{
    public function __construct()
    {
        while (!empty($events = $this->getEventsData())) {
            foreach ($events as $event) {
                $elementId = $event["EVENT_DATA"]["FIELDS"]["ID"];
                try {
                    switch ($event["EVENT_NAME"]) {
                        case "ONCRMDEALUPDATE":
                            new DealController($elementId);
                            break;
                        case "ONCRMDYNAMICITEMUPDATE_149":
                        case "ONCRMDYNAMICITEMADD_149":
//                            (new TrainingService())->handle($event["EVENT_DATA"]["FIELDS"]["ID"]);
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
