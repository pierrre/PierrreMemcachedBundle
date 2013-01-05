<?php

namespace Pierrre\MemcachedBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FlushCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('pierrre:memcached:flush')->setDescription('Flush Memcached');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memcached = $this->getContainer()->get('pierrre_memcached.default_connection');
        $memcached->flush();
    }
}
