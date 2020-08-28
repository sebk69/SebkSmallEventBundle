<?php
/**
 * This file is a part of SebkSmallEventsBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallEventsBundle\Command;


use App\Event\TestEvent;
use Sebk\SmallEventsBundle\Dispatcher\MessageBroker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListenCommand
 * @package Sebk\SmallEventsBundle\Command
 * Listen for message broker and manage events
 */
class ListenCommand extends Command
{
    protected static $defaultName = "sebk:small-events:listen";
    protected $messageBroker;

    public function __construct(MessageBroker $messageBroker)
    {
        $this->messageBroker = $messageBroker;

        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->messageBroker->listen();
    }
}