<?php

namespace Zrcms\ContentCore\View\Fields;

use Zrcms\Content\Fields\FieldsContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsView extends FieldsContent
{
    const SITE_CMS_RESOURCE = 'siteCmsResource';
    const PAGE_CONTAINER_CMS_RESOURCE = 'pageContainerCmsResource';
    const LAYOUT_CMS_RESOURCE = 'themeLayoutCmsResource';
    const RENDERER = 'renderer';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::SITE_CMS_RESOURCE,
                'type' => 'object',
                'label' => 'SiteCmsResource',
                'required' => true,
                'default' => null,
                'options' => [],
            ],
            [
                'name' => self::PAGE_CONTAINER_CMS_RESOURCE,
                'type' => 'object',
                'label' => 'PageContainerCmsResource',
                'required' => true,
                'default' => null,
                'options' => [],
            ],
            [
                'name' => self::LAYOUT_CMS_RESOURCE,
                'type' => 'object',
                'label' => 'ThemeLayoutCmsResource',
                'required' => true,
                'default' => null,
                'options' => [],
            ],
            [
                'name' => self::RENDERER,
                'type' => 'zrcms-service',
                'label' => 'Renderer (layout renderer)',
                'required' => false,
                'default' => 'layout',
                'options' => [],
            ],
        ];
}