<?php

namespace Beupsoft\Fenix\App\Controller;

use Beupsoft\Fenix\App\Bitrix;
use Beupsoft\Fenix\App\DTO\DealDTO;
use Beupsoft\Fenix\App\Logging;
use Beupsoft\Fenix\App\Repository\DealRepository;
use Beupsoft\Fenix\App\Repository\TrainingRepository;
use Exception;
use Symfony\Component\Dotenv\Dotenv;

class SubscriptionController
{
    public function __construct()
    {
        while (!empty($events = $this->getEventsData())) {
            foreach ($events as $event) {
                switch ($event["EVENT_NAME"]) {
                    case "ONCRMDEALUPDATE":
                        $deal = $this->getDeal($event["EVENT_DATA"]["FIELDS"]["ID"]);
                        $this->routeDeal($deal);
                        break;
                    case "ONCRMDYNAMICITEMADD":
                        # code...
                        break;
                    case "ONCRMDYNAMICITEMUPDATE":
                        # code...
                        break;
                    case "ONCRMDYNAMICITEMDELETE":
                        # code...
                        break;
                    case "ONCALENDARENTRYUPDATE":
                        # code...
                        break;
                    case "ONCALENDARENTRYDELETE":
                        # code...
                        break;
                    default:
                        // Logging::save($events, "events", "listener");
                }
            }
            
        }
    }

    private function getEventsData(): array
    {
        $response = Bitrix::call("event.offline.get");
        return $response["result"]["events"] ?? [];
    }

    private function getDeal(int $dealId): DealDTO
    {
        $repository = new DealRepository();
        return $repository->findByDealId($dealId);
    }

    private function routeDeal(DealDTO $deal): void
    {
        if($deal->getPipeline() == 6) {
            switch ($deal->getStage()) {
                case 'C6:PREPARATION':
                    # create trainings
                    break;
                case 'C6:PREPAYMENT_INVOICE':
                    # update trainings
                    break;
                default:
                    # skip
                    break;
            }
        }
    }

    private function createTrainings(DealDTO $deal): void
    {
        $repository = new TrainingRepository();
        $repository->findTrainingsByDealId($deal->getId());
    }
}
