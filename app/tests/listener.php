<?php

use Beupsoft\Fenix\App\Service\InstallService;
use Beupsoft\Fenix\App\Bitrix;

try {

    function deleteListeners(): array
    {
        $data = [];

        $listeners = getListeners();

        if ($listeners) {
            foreach ($listeners as $listener) {
                $data[$listener["event"]] = [
                    "method" => "event.unbind",
                    "params" => [
                        "event" => $listener["event"],
                    ],
                ];

                if (isset($listener["handler"])) {
                    $data[$listener["event"]]["params"]["handler"] = $listener["handler"];
                } else {
                    $data[$listener["event"]]["params"]["event_type"] = "offline";
                }
            }
        }

        return Bitrix::callBatch($data);
    }

    function getListeners()
    {
        return Bitrix::call("event.get")["result"];
    }

    function getEvents(): array
    {
        return Bitrix::call("event.offline.get")["events"] ?? [];
    }

    // $response = deleteListeners();
    $response = getListeners();
    // $response = getEvents();


    // $response = Bitrix::call("event.get");
    // $response = Bitrix::call("event.offline.get");




} catch (Throwable $th) {
    $response = [
        'code' => $th->getCode(),
        'message' => $th->getMessage(),
        'file' => $th->getFile(),
        'line' => $th->getLine(),
    ];
} finally {
    dd($response);
}
