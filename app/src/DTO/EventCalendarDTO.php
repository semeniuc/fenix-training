<?php

namespace Beupsoft\Fenix\App\DTO;

use DateTime;

class EventCalendarDTO 
{
    private ?int $id;
    private ?string $type;
    private ?int $ownerId;
    private ?int $section;
    private ?string $accessibility;
    private ?DateTime $from;
    private ?DateTime $to;
    private ?string $name;
    private ?string $description;
    private ?string $isMeeting;
    private ?string $location;
    private ?array $attendees;
    private ?string $color;
    private ?string $textColor;

    public function __construct(array $data)
    {
        $this->id = $data["id"] ?? null;
        $this->type = $data["type"] ?? null;
        $this->ownerId = $data["ownerId"] ?? null;
        $this->section = $data["section"] ?? null;
        $this->accessibility = $data["accessibility"] ?? null;
        $this->from = (!empty($data['from'])) ? new DateTime($data['from']) : null;
        $this->to = (!empty($data['to'])) ? new DateTime($data['to']) : null;
        $this->name = $data['name'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->isMeeting = $data['is_meeting'] ?? null;
        $this->location = $data['location'] ?? null;
        $this->attendees = $data['attendees'] ?? null;
        $this->color = $data['color'] ?? null;
        $this->textColor = $data['text_color'] ?? null;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of type
     */ 
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the value of ownerId
     */ 
    public function getOwnerId()
    {
        return $this->ownerId;
    }

    /**
     * Get the value of section
     */ 
    public function getSection()
    {
        return $this->section;
    }

    /**
     * Get the value of accessibility
     */ 
    public function getAccessibility()
    {
        return $this->accessibility;
    }

    /**
     * Get the value of from
     */ 
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * Get the value of to
     */ 
    public function getTo()
    {
        return $this->to;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of is_meeting
     */ 
    public function getIsmeeting()
    {
        return $this->isMeeting;
    }

    /**
     * Get the value of location
     */ 
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Get the value of attendees
     */ 
    public function getAttendees()
    {
        return $this->attendees;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Get the value of text_color
     */ 
    public function getTextColor()
    {
        return $this->textColor;
    }
}