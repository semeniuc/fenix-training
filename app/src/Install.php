<?php

namespace Beupsoft\Fenix\App;

use Beupsoft\App\Config\TrainingConfig;

class Install
{
    public function __construct()
    {
        $this->response($this->execute());
    }

    public function execute(): bool
    {
        if ($isSuccessInstall = $this->app()) {
            $this->listener();
        }

        return $isSuccessInstall;
    }

    private function app(): bool
    {
        return Bitrix::installApp()["install"];
    }

    private function response(bool $isSuccessInstall): void
    {
        $htmlHead =
            "<head>
            <script src=\"//api.bitrix24.com/api/v1/\"></script>
            <script>
                BX24.init(function () {
                    BX24.installFinish();
                });
            </script>
        </head>";

        if ($isSuccessInstall === true) {
            echo $htmlHead . "<body>installation has been finished</body>";
        } else {
            echo "<body>installation error</body>";
        }
    }

    private function listener(): array
    {
        $trainingEntityTypeId = TrainingConfig::getEntityTypeId();

        $events = [
            "onCrmDealUpdate",
            "OnCalendarEntryUpdate",
            "OnCalendarEntryDelete",
            "onCrmDynamicItemAdd_" . $trainingEntityTypeId,
            "onCrmDynamicItemUpdate_" . $trainingEntityTypeId,
        ];

        $data = [];

        foreach ($events as $event) {
            $data[$event] = [
                "method" => "event.bind",
                "params" => [
                    "event" => $event,
                    "event_type" => "offline",
                ],
            ];
        }

        $handler = $_ENV["APP_PUBLIC_URL"] . "?event=listener";
        $data["onOfflineEvent"] = [
            "method" => "event.bind",
            "params" => [
                "event" => "ONOFFLINEEVENT",
                "handler" => $handler,
                'options' => [
                    'minTimeout' => 5,
                ],
            ],
        ];

        return Bitrix::callBatch($data);
    }
}
