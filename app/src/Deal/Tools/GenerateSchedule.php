<?php

declare(strict_types=1);

namespace Beupsoft\Fenix\App\Deal\Tools;

class GenerateSchedule
{
    private function getTrainingSchedule(\DateTime $startDate, array $daysAndTime, int $numberTrainings): array
    {
        $data = [];

        // Determine the date of the first training
        $firstDay = min(array_column($daysAndTime, 'day'));
        $firstTrainingDate = clone $startDate;
        $firstTrainingDate->modify("next Monday");

        $currentDate = new \DateTime();
        while (
            $firstTrainingDate->format("N") != $firstDay
            && $firstTrainingDate < $startDate
            && $firstTrainingDate < $currentDate
        ) {
            $firstTrainingDate->modify("+1 day");
        }

        // Get dates
        $count = 0;
        $weekOffset = 0;
        while ($count < $numberTrainings) {
            foreach ($daysAndTime as $key => $value) {
                $dayOfWeek = $value['day'];

                // Set date
                $trainingDate = clone $firstTrainingDate;
                $trainingDate->modify("+" . ($weekOffset * 7 + $dayOfWeek - 1) . " days");

                // Set time
                $time = $value['time'];
                $timeParts = explode(':', $time);
                $trainingDate->setTime((int)$timeParts[0], (int)$timeParts[1]);

                // Save
                $data[] = $trainingDate;

                $count++;
                if ($count >= $numberTrainings) {
                    break;
                }
            }
            $weekOffset++;
        }

        return $data;
    }
}