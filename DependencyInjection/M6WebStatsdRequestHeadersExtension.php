<?php

namespace M6Web\Bundle\StatsdRequestHeadersBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class M6WebStatsdRequestHeadersExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('m6_web_statsd_request_headers.headers', $config['headers']);
        $container->setParameter('m6_web_statsd_request_headers.routes', $config['routes']);
        $container->setParameter('m6_web_statsd_request_headers.event', preg_replace('/[^\w\-]/', '', $config['event']));

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
