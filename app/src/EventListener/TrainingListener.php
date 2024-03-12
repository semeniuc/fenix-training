<?php 

namespace Beupsoft\Fenix\App\EventListener;

class TrainingListener extends Listener
{    
    private static $events = [
        "add" => "onCrmDynamicItemAdd",
        "upd" => "onCrmDynamicItemUpdate",
        "del" => "onCrmDynamicItemDelete",
    ];

    public function __construct()
    {
        parent::__construct(self::$events);
    }
}