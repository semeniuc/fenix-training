<?php

namespace Beupsoft\Fenix\App\DTO;

use DateTime;

class TrainingDTO 
{
    private ?int $id;
    private ?string $title; // title
    private ?string $categoryId; // categoryId
    private ?string $stageId; // stageId

    private ?int $dealId; // parentId2
    private ?int $eventId; // ufCrm22EventId
    private ?int $responsibleId; // assignedById

    private ?DateTime $datetimeTraining; // ufCrm22_1709804621873

    private ?string $whoIsClosed; // ufCrm22_1709810191984


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
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

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
    public function setCategoryId($categoryId)
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
    public function setStageId($stageId)
    {
        $this->stageId = $stageId;

        return $this;
    }

    /**
     * Get the value of dealId
     */ 
    public function getDealId()
    {
        return $this->dealId;
    }

    /**
     * Set the value of dealId
     *
     * @return  self
     */ 
    public function setDealId($dealId)
    {
        $this->dealId = $dealId;

        return $this;
    }

    /**
     * Get the value of eventId
     */ 
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set the value of eventId
     *
     * @return  self
     */ 
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get the value of responsibleId
     */ 
    public function getResponsibleId()
    {
        return $this->responsibleId;
    }

    /**
     * Set the value of responsibleId
     *
     * @return  self
     */ 
    public function setResponsibleId($responsibleId)
    {
        $this->responsibleId = $responsibleId;

        return $this;
    }

    /**
     * Get the value of datetimeTraining
     */ 
    public function getDatetimeTraining()
    {
        return $this->datetimeTraining;
    }

    /**
     * Set the value of datetimeTraining
     *
     * @return  self
     */ 
    public function setDatetimeTraining($datetimeTraining)
    {
        $this->datetimeTraining = $datetimeTraining;

        return $this;
    }

    /**
     * Get the value of whoIsClosed
     */ 
    public function getWhoIsClosed()
    {
        return $this->whoIsClosed;
    }

    /**
     * Set the value of whoIsClosed
     *
     * @return  self
     */ 
    public function setWhoIsClosed($whoIsClosed)
    {
        $this->whoIsClosed = $whoIsClosed;

        return $this;
    }
}