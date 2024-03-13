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
    private ?string $is_meeting;
    private ?string $location;
    private ?array $attendees;
    private ?string $color;
    private ?string $text_color;

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
        $this->is_meeting = $data['is_meeting'] ?? null;
        $this->location = $data['location'] ?? null;
        $this->attendees = $data['attendees'] ?? null;
        $this->color = $data['color'] ?? null;
        $this->text_color = $data['text_color'] ?? null;
    }
}