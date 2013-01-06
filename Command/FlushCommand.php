<?php

namespace Pierrre\MemcachedBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FlushCommand extends MemcachedCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('pierrre:memcached:flush')->setDescription('Flush Memcached');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memcached = $this->getOptionInstance($input);
        $memcached->flush();
    }
}
