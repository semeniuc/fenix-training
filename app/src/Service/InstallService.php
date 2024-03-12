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

    public function listener(): array
    {
        $data = array_merge(
            (new TrainingListener())->getListenerEvents(),
            (new DealListener())->getListenerEvents(),
            (new EventListener())->getListenerEvents(),
        );

        return $this->execute($data);
    }

    private function execute(array $data): array 
    {
        return Bitrix::callBatch($data);
    }
}