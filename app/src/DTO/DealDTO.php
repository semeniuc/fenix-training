<?php

namespace Beupsoft\Fenix\App\DTO;

use DateTime;

class DealDTO 
{
    private ?int $id;
    private ?int $categoryId; // categoryId
    private ?string $stageId; // stageId
    private ?int $assignedById; // assignedById
    private ?array $days; // ufCrm_1709801608762
    private ?int $time; // ufCrm_1709801802210

    public function __construct(array $data)
    {
        $this->id = $data["id"] ?? null;
        $this->categoryId = $data["categoryId"] ?? null;
        $this->stageId = $data["stageId"] ?? null;
        $this->assignedById = $data["assignedById"] ?? null;
        $this->days = $data["ufCrm_1709801608762"] ?? null;
        $this->time = $data["ufCrm_1709801802210"] ?? null;
    }
  

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of categoryId
     */ 
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Get the value of stageId
     */ 
    public function getStageId()
    {
        return $this->stageId;
    }

    /**
     * Get the value of assignedById
     */ 
    public function getAssignedById()
    {
        return $this->assignedById;
    }

    /**
     * Get the value of days
     */ 
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }
}