<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Api\Repository;

use Psr\Container\ContainerInterface;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

/**
 * @deprecated BC only
 * @author     James Jervis - https://github.com/jerv13
 */
class ReadBlockComponentRegistryBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadBlockComponentRegistryBc
     */
    public function __invoke(
        $serviceContainer
    ) {
        $config = $serviceContainer->get('config');

        $registry = $config['zrcms']['blocks'];

        $pluginConfigsBc = $config['rcmPlugin'];

        return new ReadBlockComponentRegistryBc(
            $registry,
            $pluginConfigsBc,
            $serviceContainer->get(GetServiceFromAlias::class)
        );
    }
}
