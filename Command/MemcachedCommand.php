<?php

namespace Pierrre\MemcachedBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;

abstract class MemcachedCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->addOption('instance', null, InputOption::VALUE_OPTIONAL, 'Instance name');
    }

    protected function getOptionInstance(InputInterface $input)
    {
        $instanceName = $input->getOption('instance');

        if (is_null($instanceName)) {
            return $this->getContainer()->get('pierrre_memcached.default_instance');
        } else {
            return $this->getContainer()->get('pierrre_memcached.instance.' . $instanceName);
        }
    }
}
