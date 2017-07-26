<?php

namespace Zrcms\ContentLanguageDoctrine;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'doctrine' => [
                'driver' => [
                    ModuleConfig::class => [
                        'class' => AnnotationDriver::class,
                        'cache' => 'array',
                        'paths' => [
                            __DIR__ . '/../Entity',
                        ]
                    ],
                    'orm_default' => [
                        'drivers' => [
                            ModuleConfig::class => ModuleConfig::class
                        ]
                    ]
                ],
            ],
        ];
    }
}