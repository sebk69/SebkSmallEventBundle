<?php
/**
 * This file is a part of SebkSmallEventsBundle
 * Copyright 2020 - Sébastien Kus
 * Under GNU GPL V3 licence
 */

namespace Sebk\SmallEventsBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;

class SebkSmallEventsExtension extends Extension
{

    /**
     * Load bundle
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        // Read configuration
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        // Load service.yml
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        // Populate container with configuration
        $container->setParameter("sebk_small_events", $config);
    }

}