<?php

namespace Pierrre\MemcachedBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('pierrre:memcached:stats')->setDescription('Displays Memcached stats');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memcached = $this->getContainer()->get('pierrre_memcached.default_connection');
        $stats = $memcached->getStats();
        $output->writeln(print_r($stats, true));
    }
}
