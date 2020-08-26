<?php


namespace Sebk\SmallEventsBundle\Command;


use Sebk\SmallEventsBundle\Events\MessageBroker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected $messageBroker;
    protected static $defaultName = "sebk:small-events:test";

    public function __construct(MessageBroker $messageBroker)
    {
        $this->messageBroker = $messageBroker;

        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->messageBroker->createQueues();

        return 0;
    }
}