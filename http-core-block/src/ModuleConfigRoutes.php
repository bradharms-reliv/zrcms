<?php

namespace Zrcms\HttpCoreBlock;

use Zrcms\HttpCoreBlock\Api\Render\RenderBlockJsTag;
use Zrcms\HttpCoreBlock\Middleware\BlockJs;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [
                'zrcms.block.block.js' => [
                    'name' => 'zrcms.block.block.js',
                    'path' => '/zrcms/block/block.js',
                    'middleware' => [
                        'middleware' => BlockJs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'zrcms-view-head.head-script' => [
                'sections' => [
                    'modules' => [
                        'zrcms.block.block.js' => [
                            '__render_service' => '{render-service}',
                            RenderBlockJsTag::OPTION_JS_URL => '/zrcms/block/block.js',
                        ],
                    ],
                ],
            ],
        ];
    }
}
