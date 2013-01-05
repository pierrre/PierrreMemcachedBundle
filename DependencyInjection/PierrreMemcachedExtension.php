<?php

namespace Pierrre\MemcachedBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PierrreMemcachedExtension extends Extension
{
    /**
     * @see Symfony\Component\DependencyInjection\Extension\ExtensionInterface::load()
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $connections = $config['connections'];
        foreach ($connections as $connectionName => $connection) {
            $definition = new Definition('Memcached');

            if (isset($connection['persistent_id'])) {
                $definition->addArgument($connection['persistent_id']);
            }

            foreach ($connection['servers'] as $server) {
                $definition->addMethodCall('addServer', array($server['host'], $server['port'], $server['weight']));
            }

            foreach ($connection['options'] as $optionName => $optionValue) {
                $definition->addMethodCall('setOption', array($optionName, $optionValue));
            }

            $container->setDefinition($this->getAlias() . '.connection.' . $connectionName , $definition);
        }

        if (isset($config['default_connection'])) {
            $defaultConnectionName = $config['default_connection'];
        } else {
            $connectionNames = array_keys($config['connections']);
            $defaultConnectionName = array_pop($connectionNames);
        }

        $container->setAlias($this->getAlias() . '.default_connection', $this->getAlias() . '.connection.' . $defaultConnectionName);
    }
}
