<?php

namespace Pierrre\MemcachedBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StatsCommand extends MemcachedCommand
{
    protected function configure()
    {
        parent::configure();

        $this->setName('pierrre:memcached:stats')->setDescription('Displays Memcached stats');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $memcached = $this->getOptionInstance($input);
        $stats = $memcached->getStats();
        $output->writeln(print_r($stats, true));
    }
}
