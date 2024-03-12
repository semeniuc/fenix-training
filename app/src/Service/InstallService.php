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
        $data = array_merge(
            (new TrainingListener())->getListenerEvents(),
            (new DealListener())->getListenerEvents(),
            (new EventListener())->getListenerEvents(),
        );

        return Bitrix::callBatch($data);
    }
}