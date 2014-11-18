<?php

/*
 * This file is part of the ONGR package.
 *
 * (c) NFQ Technologies UAB <info@nfq.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace ONGR\AdminBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * This is the class that loads and manages bundle configuration.
 */
class ONGRAdminExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('services/auth.yml');
        $loader->load('services/flash_bag.yml');
        $loader->load('services/settings.yml');

        if (isset($config['power_user'])) {
            $this->loadPowerUserSettings($config['power_user'], $container);
        }
    }

    /**
     * Sets parameters for power user.
     *
     * @param array             $config
     * @param ContainerBuilder  $containerBuilder
     */
    protected function loadPowerUserSettings($config, ContainerBuilder $containerBuilder)
    {
        $containerBuilder->setParameter('ongr_admin.settings.categories', $config['categories']);
        $containerBuilder->setParameter('ongr_admin.settings.settings', $config['settings']);
    }
}
