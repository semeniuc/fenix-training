<?php

namespace Beupsoft\Fenix\App\DTO;

use DateTime;

class DealDTO 
{
    private ?int $id;
    private ?int $categoryId;
    private ?string $stageId;
    private ?int $assignedById;
    private ?array $daysAndTime;
    private ?DateTime $startDate;
    private ?int $numberTrainings;
    private ?DateTime $startDatePause;
    private ?DateTime $endDatePause;
    private ?string $title;
    private ?int $contactId;

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->categoryId = $data["categoryId"];
        $this->stageId = $data["stageId"];
        $this->assignedById = $data["assignedById"];
        $this->daysAndTime = $data["daysAndTime"];
        $this->startDate = (!empty($data['startDate'])) ? new DateTime($data['startDate']) : null;
        $this->numberTrainings = $data["numberTrainings"];
        $this->startDatePause = (!empty($data['startDatePause'])) ? new DateTime($data['startDatePause']) : null;
        $this->endDatePause = (!empty($data['endDatePause'])) ? new DateTime($data['endDatePause']) : null;
        $this->title = $data["title"];
        $this->contactId = $data["contactId"];
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    /**
     * @return string|null
     */
    public function getStageId(): ?string
    {
        return $this->stageId;
    }

    /**
     * @return int|null
     */
    public function getAssignedById(): ?int
    {
        return $this->assignedById;
    }

    /**
     * @return array|null
     */
    public function getDaysAndTime(): ?array
    {
        return $this->daysAndTime;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDate(): ?DateTime
    {
        return $this->startDate;
    }

    /**
     * @return int|null
     */
    public function getNumberTrainings(): ?int
    {
        return $this->numberTrainings;
    }

    /**
     * @return DateTime|null
     */
    public function getStartDatePause(): ?DateTime
    {
        return $this->startDatePause;
    }

    /**
     * @return DateTime|null
     */
    public function getEndDatePause(): ?DateTime
    {
        return $this->endDatePause;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return int|null
     */
    public function getContactId(): ?int
    {
        return $this->contactId;
    }
}