<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace AppBundle\DependencyInjection;

use Fluent\PhpConfigFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class AppExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new PhpConfigFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $files = [
            'services',
        ];
        foreach ($files as $basename) {
            $loader->load(sprintf('%s.php', $basename));
        }
    }
}
