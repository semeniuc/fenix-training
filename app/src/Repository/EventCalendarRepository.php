<?php 

namespace Beupsoft\Fenix\App\Repository;

use Exception;
use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\EventCalendarDTO;

# TODO: Настроить получение проверяемых полей и значений из конфига
class EventCalendarRepository
{
    public function get(int $eventId)
    {
        // $eventData = Bitrix::call("calendar.event.getbyid", ["id" => $eventId]);
        $eventData = Bitrix::call("calendar.event.get", [
            "id" => $eventId
        ]);

        // return new DealDTO($dealData);

        return $eventData;
    }

    public function add(object $dto) 
    {
        
    }
}