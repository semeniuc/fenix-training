<?php

namespace Beupsoft\Fenix\App\DTO;

class DealDTO 
{
    private ?int $id;
    private ?int $categoryId;
    private ?string $stageId;
    private ?int $assignedById;
    private ?array $days;
    private ?string $time;

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of categoryId
     */ 
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set the value of categoryId
     *
     * @return  self
     */ 
    public function setCategoryId(?int $categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get the value of stageId
     */ 
    public function getStageId()
    {
        return $this->stageId;
    }

    /**
     * Set the value of stageId
     *
     * @return  self
     */ 
    public function setStageId(?string $stageId)
    {
        $this->stageId = $stageId;

        return $this;
    }

    /**
     * Get the value of assignedById
     */ 
    public function getAssignedById()
    {
        return $this->assignedById;
    }

    /**
     * Set the value of assignedById
     *
     * @return  self
     */ 
    public function setAssignedById(?int $assignedById)
    {
        $this->assignedById = $assignedById;

        return $this;
    }

    /**
     * Get the value of days
     */ 
    public function getDays()
    {
        return $this->days;
    }

    /**
     * Set the value of days
     *
     * @return  self
     */ 
    public function setDays(?array $days)
    {
        $this->days = $days;

        return $this;
    }

    /**
     * Get the value of time
     */ 
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set the value of time
     *
     * @return  self
     */ 
    public function setTime(?string $time)
    {
        $this->time = $time;

        return $this;
    }
}