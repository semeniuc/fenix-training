<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Actions;

use Beupsoft\Fenix\App\Deal\DealDTO;
use Beupsoft\Fenix\App\Deal\Repository\DealRepository;
use Beupsoft\Fenix\App\Deal\Repository\EventRepository;
use Beupsoft\Fenix\App\Deal\Repository\TrainingRepository;

class PauseTrainingsAction
{
    private DealRepository $dealRepository;
    private TrainingRepository $trainingRepository;
    private EventRepository $eventRepository;

    public function __construct(private readonly DealDTO $dealDTO)
    {
        $this->dealRepository = new DealRepository();
        $this->trainingRepository = new TrainingRepository();
        $this->eventRepository = new EventRepository();
    }

    public function execute()
    {
    }
}