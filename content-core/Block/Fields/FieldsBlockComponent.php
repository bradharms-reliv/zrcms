<?php

namespace Zrcms\ContentCore\Block\Fields;

use Zrcms\Content\Fields\FieldsComponent;
use Zrcms\ContentCore\Block\Model\BlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsBlockComponent extends FieldsComponent
{
    // required
    const DEFAULT_CONFIG = 'defaultConfig';
    const CACHEABLE = 'cache';

    const RENDERER = 'renderer';
    const DATA_PROVIDER = 'data-provider';
    const FIELDS = 'fields';

    // client only
    const ICON = 'icon';
    const EDITOR = 'editor';
    const CATEGORY = 'category';
    const LABEL = 'label';
    const DESCRIPTION = 'description';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::COMPONENT_CONFIG_READER,
                'type' => 'zrcms-service',
                'label' => 'Component Config Reader',
                'required' => false,
                'default' => 'json',
                'options' => [],
            ],
            [
                'name' => self::COMPONENT_CLASS,
                'type' => 'class',
                'label' => 'Component Class',
                'required' => false,
                'default' => BlockComponent::class,
                'options' => [],
            ],
            [
                'name' => self::DEFAULT_CONFIG,
                'type' => 'array',
                'label' => 'Default Config',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::CACHEABLE,
                'type' => 'bool',
                'label' => 'Cachable',
                'required' => false,
                'default' => false,
                'options' => [],
            ],
            [
                'name' => self::RENDERER,
                'type' => 'zrcms-service',
                'label' => 'Renderer',
                'required' => false,
                'default' => 'mustache',
                'options' => [],
            ],
            [
                'name' => self::DATA_PROVIDER,
                'type' => 'zrcms-service',
                'label' => 'Data Provider',
                'required' => false,
                'default' => 'noop',
                'options' => [],
            ],
            [
                'name' => self::FIELDS,
                'type' => 'fields',
                'label' => 'Fields',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::ICON,
                'type' => 'text',
                'label' => 'Icon Path',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::EDITOR,
                'type' => 'text',
                'label' => 'Client Editor',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::CATEGORY,
                'type' => 'text',
                'label' => 'Category',
                'required' => false,
                'default' => 'General',
                'options' => [],
            ],
            [
                'name' => self::LABEL,
                'type' => 'text',
                'label' => 'Label',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::DESCRIPTION,
                'type' => 'text',
                'label' => 'Description',
                'required' => false,
                'default' => '',
                'options' => [],
            ],
        ];
}