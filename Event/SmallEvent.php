<?php
/**
 * This file is a part of SebkSmallEventsBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallEventsBundle\Event;


use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class SmallEvent
 * @package Sebk\SmallEventsBundle\Event
 */
class SmallEvent extends Event
{
    /** @var string */
    protected $eventName = "";
    /** @var \DateTime */
    protected $dateEmitted;
    protected $data = "";

    /**
     * Force date of emission
     * @param \DateTime $date
     * @return $this
     */
    public function setDateEmitted(\DateTime $date): SmallEvent
    {
        $this->dateEmitted = $date;

        return $this;
    }

    /**
     * Get date of emission
     * @return \DateTime
     */
    public function getDateEmitted(): \DateTime
    {
        return $this->dateEmitted;
    }

    /**
     * Set event name
     * @param string $eventName
     * @return $this
     */
    public function setEventName(string $eventName): SmallEvent
    {
        $this->eventName = $eventName;

        return $this;
    }

    /**
     * Get event name
     * @return string
     */
    public function getEventName(): string
    {
        return $this->eventName;
    }

    /**
     * Set data of event
     * @param $data
     * @return $this
     */
    public function setData($data): SmallEvent
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data of event
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }
}