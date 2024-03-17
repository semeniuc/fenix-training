<?php

namespace Beupsoft\Fenix\App\Training;

use DateTime;

class TrainingDTO
{
    private ?int $id;
    private ?string $title;
    private ?int $categoryId;
    private ?string $stageId;
    private ?int $dealId;
    private ?int $eventId;
    private ?int $assignedById;
    private ?DateTime $datetimeTraining;
    private ?int $whoIsClosed;
    private ?int $contactId;

    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->title = $data["title"];
        $this->categoryId = $data["categoryId"];
        $this->stageId = $data["stageId"];
        $this->dealId = $data["dealId"];
        $this->eventId = $data["eventId"];
        $this->assignedById = $data["assignedById"];
        $this->datetimeTraining = (!empty($data['datetimeTraining'])) ? new DateTime($data['datetimeTraining']) : null;
        $this->whoIsClosed = $data["whoIsClosed"];
        $this->contactId = $data["contactId"];
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

    /**
     * @return int|null
     */
    public function getContactId(): ?int
    {
        return $this->contactId;
    }
}