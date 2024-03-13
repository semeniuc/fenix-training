<?php

namespace Beupsoft\Fenix\App\DTO;

class DealDTO 
{
    private ?int $id;
    private ?int $pipeline;
    private ?string $stage;
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
     * Get the value of pipeline
     */ 
    public function getPipeline()
    {
        return $this->pipeline;
    }

    /**
     * Set the value of pipeline
     *
     * @return  self
     */ 
    public function setPipeline(?int $pipeline)
    {
        $this->pipeline = $pipeline;

        return $this;
    }

    /**
     * Get the value of stage
     */ 
    public function getStage()
    {
        return $this->stage;
    }

    /**
     * Set the value of stage
     *
     * @return  self
     */ 
    public function setStage(?string $stage)
    {
        $this->stage = $stage;

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