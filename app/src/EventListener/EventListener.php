<?php 

namespace Beupsoft\Fenix\App\EventListener;

class EventListener extends Listener
{    
    private static $events = [
        "upd" => "OnCalendarEntryUpdate",
        "del" => "OnCalendarEntryDelete",
    ];

    public function __construct()
    {
        parent::__construct(self::$events);
    }
}