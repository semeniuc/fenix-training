<?php

namespace Beupsoft\Fenix\App\Deal;

use DateTime;

class DealDTO
{
    private ?int $id;
    private ?string $title;
    private ?int $contactId;
    private ?int $categoryId;
    private ?string $stageId;
    private ?int $assignedById;
    private ?array $daysAndTime;
    private ?DateTime $startDate;
    private ?int $numberTrainings;
    private ?DateTime $startDatePause;
    private ?DateTime $endDatePause;
    private ?DateTime $lastDateTraining;
    private ?string $trainingsCreationStatus;

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->title = $data["title"];
        $this->contactId = $data["contactId"];
        $this->categoryId = $data["categoryId"];
        $this->stageId = $data["stageId"];
        $this->assignedById = $data["assignedById"];
        $this->daysAndTime = $data["daysAndTime"];
        $this->startDate = (!empty($data['startDate'])) ? new DateTime($data['startDate']) : null;
        $this->numberTrainings = $data["numberTrainings"];
        $this->startDatePause = (!empty($data['startDatePause'])) ? new DateTime($data['startDatePause']) : null;
        $this->endDatePause = (!empty($data['endDatePause'])) ? new DateTime($data['endDatePause']) : null;
        $this->lastDateTraining = (!empty($data['lastDateTraining'])) ? new DateTime($data['lastDateTraining']) : null;
        $this->trainingsCreationStatus = $data["trainingsCreationStatus"];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getContactId(): ?int
    {
        return $this->contactId;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getStageId(): ?string
    {
        return $this->stageId;
    }

    public function getAssignedById(): ?int
    {
        return $this->assignedById;
    }

    public function getDaysAndTime(): ?array
    {
        return $this->daysAndTime;
    }

    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    public function getNumberTrainings(): ?int
    {
        return $this->numberTrainings;
    }

    public function getStartDatePause(): ?DateTime
    {
        return $this->startDatePause;
    }

    public function getEndDatePause(): ?DateTime
    {
        return $this->endDatePause;
    }

    public function getLastDateTraining(): ?DateTime
    {
        return $this->lastDateTraining;
    }

    public function getTrainingsCreationStatus(): ?string
    {
        return $this->trainingsCreationStatus;
    }
}