<?php

namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mysql_backup_tool');

        $rootNode
            ->children()
                ->arrayNode('servers')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('hostname')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('port')
                                ->defaultValue('3306')
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('username')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('password')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('users')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('username')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('password')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('roles')
                                ->prototype('scalar')->end()
                                ->defaultValue(['ROLE_USER'])
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('backups')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('server')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('storage_path')
                                ->defaultValue('%kernel.root_dir%/../storage')
                            ->end()
                            ->scalarNode('options')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
