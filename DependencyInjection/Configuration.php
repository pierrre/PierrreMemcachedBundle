<?php

namespace Pierrre\MemcachedBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @see Symfony\Component\Config\Definition.ConfigurationInterface::getConfigTreeBuilder()
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootnode = $treeBuilder->root('pierrre_memcached');

        $rootnode
            ->children()
                ->scalarNode('default_instance')->end()
                ->arrayNode('instances')
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('persistent_id')->end()
                            ->arrayNode('servers')
                                ->requiresAtLeastOneElement()
                                ->useAttributeAsKey('name')
                                ->prototype('array')
                                    ->children()
                                        ->scalarNode('host')->defaultValue('localhost')->end()
                                        ->scalarNode('port')->defaultValue(11211)->end()
                                        ->scalarNode('weight')->defaultValue(0)->end()
                                    ->end()
                                ->end()
                                ->addDefaultChildrenIfNoneSet('default')
                            ->end()
                            ->arrayNode('options')
                                ->prototype('scalar')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->addDefaultChildrenIfNoneSet('default')
                ->end()
                ->arrayNode('session')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->scalarNode('instance')->end()
                        ->arrayNode('options')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('prefix')->end()
                                ->scalarNode('expiretime')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
