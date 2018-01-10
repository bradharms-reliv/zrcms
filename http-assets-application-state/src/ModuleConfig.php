<?php

namespace Zrcms\HttpAssetsApplicationState;

use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpAssetsApplicationState\Acl\HttpApiIsAllowedApplicationState;
use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationState;
use Zrcms\HttpAssetsApplicationState\Api\Render\RenderScriptTagApplicationStateFactory;
use Zrcms\HttpAssetsApplicationState\Middleware\HttpApplicationState;
use Zrcms\HttpAssetsApplicationState\Middleware\HttpApplicationStateByRequest;
use Zrcms\HttpAssetsApplicationState\Middleware\HttpApplicationStateByRequestFactory;
use Zrcms\HttpAssetsApplicationState\Middleware\HttpApplicationStateFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    HttpApiIsAllowedApplicationState::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'application-state'],
                            ['literal' => 401],
                            ['literal' => IsDebug::invoke()]
                        ],
                    ],
                    RenderScriptTagApplicationState::class => [
                        'factory' => RenderScriptTagApplicationStateFactory::class,
                    ],
                    HttpApplicationState::class => [
                        'factory' => HttpApplicationStateFactory::class,
                    ],
                    HttpApplicationStateByRequest::class => [
                        'factory' => HttpApplicationStateByRequestFactory::class,
                    ],
                ],
            ],
        ];
    }
}
