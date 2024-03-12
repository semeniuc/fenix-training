<?php 

namespace Beupsoft\Fenix\App\EventListener;

class Listener
{    
    private array $events;

    public function __construct(array $events)
    {
        $this->events = $events;
    }

    public function getListenerEvents(): array
    {
        $data = [];
        foreach ($this->events as $event) {
            $data[$event] = [
                "method" => "event.bind",
                "params" => [
                    "event" => $event,
                    "event_type" => "offline",
                ],
            ];
        }

        $data["onOfflineEvent"] = [
            "method" => "event.bind",
            "params" => [
                "event" => "ONOFFLINEEVENT",
                "handler" => getenv("APP_PUBLIC_URL"),
                'options' => [
                    'minTimeout' => 5,
                ],
            ],
        ];

        return $data;
    }
}