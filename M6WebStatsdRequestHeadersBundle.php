<?php

namespace M6Web\Bundle\StatsdRequestHeadersBundle;

use M6Web\Bundle\StatsdRequestHeadersBundle\DependencyInjection\M6Users6PlayExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class M6WebStatsdRequestHeadersBundle
 * @package M6Web\Bundle\StatsdRequestHeadersBundle
 */
class M6WebStatsdRequestHeadersBundle extends Bundle
{
    /**
     * Build bundle
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }

    /**
     * Enable overriding conf key for this bundle
     *
     * @return M6WebStatsdRequestHeadersBundle
     */
    public function getContainerExtension()
    {
        return new M6WebStatsdRequestHeadersBundle();
    }
}
