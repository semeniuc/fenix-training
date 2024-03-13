<?php

namespace Beupsoft\Fenix\App\DTO;

use DateTime;

class TrainingDTO 
{
    private ?int $id;
    private ?string $title; // title
    private ?int $categoryId; // categoryId
    private ?string $stageId; // stageId
    private ?int $dealId; // parentId2
    private ?int $eventId; // ufCrm22EventId
    private ?int $assignedById; // assignedById
    private ?DateTime $datetimeTraining; // ufCrm22_1709804621873
    private ?int $whoIsClosed; // ufCrm22_1709810191984

    public function __construct(array $data) 
    {
        $this->id = $data["id"] ?? null;
        $this->title = $data["title"] ?? null;
        $this->categoryId = $data["categoryId"] ?? null;
        $this->stageId = $data["stageId"] ?? null;
        $this->dealId = $data["parentId2"] ?? null;
        $this->datetimeTraining = (!empty($data['ufCrm22_1709804621873'])) ? new DateTime($data['ufCrm22_1709804621873']) : null;
        $this->whoIsClosed = $data["ufCrm22_1709810191984"] ?? null;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
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
     * Get the value of dealId
     */ 
    public function getDealId()
    {
        return $this->dealId;
    }

    /**
     * Get the value of eventId
     */ 
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Get the value of assignedById
     */ 
    public function getAssignedById()
    {
        return $this->assignedById;
    }

    /**
     * Get the value of datetimeTraining
     */ 
    public function getDatetimeTraining()
    {
        return $this->datetimeTraining;
    }

    /**
     * Get the value of whoIsClosed
     */ 
    public function getWhoIsClosed()
    {
        return $this->whoIsClosed;
    }
}