<?php 

namespace Beupsoft\Fenix\App\EventListener;

class DealListener extends Listener
{    
    private static $events = [
        "add" => "onCrmDealAdd",
        "upd" => "onCrmDealUpdate",
        "del" => "onCrmDealDelete",
    ];

    public function __construct()
    {
        parent::__construct(self::$events);
    }
}