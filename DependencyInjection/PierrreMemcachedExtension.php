<?php

namespace Pierrre\MemcachedBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PierrreMemcachedExtension extends Extension
{
    /**
     * @see Symfony\Component\DependencyInjection\Extension\ExtensionInterface::load()
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $config = $this->processConfiguration(new Configuration(), $configs);

        $instances = $config['instances'];
        foreach ($instances as $instanceName => $instanceConfig) {
            $definition = new Definition();
            $definition->setClass($container->getParameter('pierrre_memcached.memcached.class'));
            $definition->setFactoryService('pierrre_memcached.memcached_factory');
            $definition->setFactoryMethod('get');
            $definition->setArguments(array($instanceConfig));

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
