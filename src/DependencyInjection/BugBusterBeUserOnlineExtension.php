<?php

/**
 * @copyright  Glen Langer 2008..2018 <http://contao.ninja>
 * @author     Glen Langer (BugBuster)
 * @package    BeUserOnlineBundle
 * @license    LGPL-3.0+
 * @see	       https://github.com/BugBuster1701/contao-be_user_online-bundle
 *
 */

namespace BugBuster\BeUserOnlineBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class BugBusterBeUserOnlineExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );

        $loader->load('listener.yml');
    }
}
