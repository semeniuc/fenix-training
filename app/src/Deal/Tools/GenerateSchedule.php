<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Tools;

use DateTime;

class GenerateSchedule
{
    public function __construct(
        private DateTime $startDate,
        private array $daysAndTime,
        private int $numberTrainings
    ) {
    }

    public function get(): array
    {
        $data = [];

        // Determine the date of the first training
        $trainingDate = $this->getTrainingDate($this->startDate);
        $data[] = $trainingDate;

        for ($i = 0; $i < $this->numberTrainings; $i++) {
            $trainingDate = $this->getTrainingDate($trainingDate);
            $data[] = $trainingDate;
        }

        // Unset last value
        unset($data[$i]);
        
        return $data;
    }

    public function getTrainingDate(DateTime $startDate): DateTime
    {
        $trainingDate = clone $startDate;
        $trainingDay = (int)$trainingDate->format("N");

        // Nearest date
        while (
            !array_key_exists($trainingDay, $this->daysAndTime)
            || $trainingDate->getTimestamp() == $startDate->getTimestamp()
        ) {
            $trainingDate->modify("+1 day");
            $trainingDay = (int)$trainingDate->format("N");
        }

        // Set time
        $item = $this->daysAndTime[$trainingDay];
        $timeParts = explode(':', $item["time"]);
        $trainingDate->setTime((int)$timeParts[0], (int)$timeParts[1]);

        return $trainingDate;
    }
}