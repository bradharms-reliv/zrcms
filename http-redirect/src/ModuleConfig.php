<?php

namespace Zrcms\HttpRedirect;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\CoreRedirect\Api\CmsResource\FindRedirectCmsResourceBySiteRequestPath;
use Zrcms\HttpRedirect\Middleware\HttpContentRedirect;

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
                    HttpContentRedirect::class => [
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindRedirectCmsResourceBySiteRequestPath::class,
                            [ 'literal' => 302],
                            [ 'literal' => []]
                        ],
                    ],
                ],
            ],
        ];
    }
}
