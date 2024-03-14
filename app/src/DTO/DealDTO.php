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

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->categoryId = $data["categoryId"];
        $this->stageId = $data["stageId"];
        $this->assignedById = $data["assignedById"];
        $this->daysAndTime = $data["daysAndTime"];
        $this->startDate = (!empty($data['startDate'])) ? new DateTime($data['startDate']) : null;
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
}