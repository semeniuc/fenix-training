<?php

namespace Beupsoft\Fenix\App\Service;

use Beupsoft\App\Config\TrainingConfig;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\EventListener\EventListener;
use Beupsoft\Fenix\App\EventListener\TrainingListener;
use Beupsoft\Fenix\App\EventListener\DealListener;

class InstallService
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

        $handler = $_ENV["APP_PUBLIC_URL"] . "listener";
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
