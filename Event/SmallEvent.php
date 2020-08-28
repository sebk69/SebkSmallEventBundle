<?php


namespace Sebk\SmallEventsBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

class SmallEvent extends Event
{
    protected $eventName = "";
    protected $data = "";
    protected $dateEmitted;

    public function setDateEmitted(\DateTime $date): SmallEvent
    {
        $this->dateEmitted = $date;

        return $this;
    }

    public function getDateEmitted(): \DateTime
    {
        return $this->dateEmitted;
    }

    public function setEventName(string $eventName): SmallEvent
    {
        $this->eventName = $eventName;

        return $this;
    }

    public function getEventName(): string
    {
        return $this->eventName;
    }

    public function setData($data): SmallEvent
    {
        $this->data = $data;

        return $this;
    }

    public function getData(): string
    {
        return $this->data;
    }
}