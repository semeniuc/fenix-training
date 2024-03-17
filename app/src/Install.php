<?php

namespace Beupsoft\Fenix\App;

use Beupsoft\App\Config\TrainingConfig;
use Beupsoft\Fenix\App\EventListener\DealListener;
use Beupsoft\Fenix\App\EventListener\EventListener;
use Beupsoft\Fenix\App\EventListener\TrainingListener;

class Install
{
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
