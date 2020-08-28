<?php
/**
 * This file is a part of SebkSmallEventsBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallEventsBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Sebk\SmallEventsBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Read configuration
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder|void
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder("sebk_small_events_bundle");
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
              ->scalarNode("application_id")
            ->end()
              ->scalarNode("rabbitmq_login")
            ->end()
              ->scalarNode("rabbitmq_password")
            ->end()
              ->scalarNode("rabbitmq_server")
            ->end()
        ;

        return $treeBuilder;
    }
}