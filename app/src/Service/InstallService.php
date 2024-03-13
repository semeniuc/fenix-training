<?php

namespace Beupsoft\Fenix\App\Service;

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\EventListener\EventListener;
use Beupsoft\Fenix\App\EventListener\TrainingListener;
use Beupsoft\Fenix\App\EventListener\DealListener;

class InstallService
{
    public function __construct()
    {
        # code...
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

    private function listener(): array
    {
        # TODO: Настроить получение trainingEnityTypeId из конфига
        $trainingEnityTypeId = 149;

        $events = [
            "onCrmDealUpdate",
            "OnCalendarEntryUpdate",
            "OnCalendarEntryDelete",
            "onCrmDynamicItemAdd_" . $trainingEnityTypeId,
            "onCrmDynamicItemUpdate_" . $trainingEnityTypeId,
            "onCrmDynamicItemDelete_" . $trainingEnityTypeId,
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

        # TODO: После тестирования включить подписку на оффлайн события

        // $handler = $_ENV["APP_PUBLIC_URL"] . "listener";
        // $data["onOfflineEvent"] = [
        //     "method" => "event.bind",
        //     "params" => [
        //         "event" => "ONOFFLINEEVENT",
        //         "handler" => $handler,
        //         'options' => [
        //             'minTimeout' => 5,
        //         ],
        //     ],
        // ];

        return Bitrix::callBatch($data);
    }
}
