<?php 

namespace Beupsoft\Fenix\App\EventListener;

class DealListener extends Listener
{    
    private static $events = [
        "upd" => "onCrmDealUpdate",
    ];

    public function __construct()
    {
        parent::__construct(self::$events);
    }
}