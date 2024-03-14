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

    public function __construct(array $data)
    {
        $this->id = $data["id"] ?? null;
        $this->categoryId = $data["categoryId"] ?? null;
        $this->stageId = $data["stageId"] ?? null;
        $this->assignedById = $data["assignedById"] ?? null;
        $this->daysAndTime = $data["daysAndTime"] ?? null;
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
}