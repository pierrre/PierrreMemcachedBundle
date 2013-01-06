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

        $instances = $config['instances'];
        foreach ($instances as $instanceName => $instance) {
            $definition = new Definition('Memcached');

            if (isset($connection['persistent_id'])) {
                $definition->addArgument($instance['persistent_id']);
            }

            foreach ($instance['servers'] as $server) {
                $definition->addMethodCall('addServer', array($server['host'], $server['port'], $server['weight']));
            }

            foreach ($instance['options'] as $optionName => $optionValue) {
                $definition->addMethodCall('setOption', array($optionName, $optionValue));
            }

            $container->setDefinition($this->getAlias() . '.instance.' . $instanceName , $definition);
        }

        if (isset($config['default_instance'])) {
            $defaultInstanceName = $config['default_instance'];
        } else {
            $instanceNames = array_keys($config['instances']);
            $defaultInstanceName = array_pop($instanceNames);
        }

        $container->setAlias($this->getAlias() . '.default_instance', $this->getAlias() . '.instance.' . $defaultInstanceName);
    }
}
