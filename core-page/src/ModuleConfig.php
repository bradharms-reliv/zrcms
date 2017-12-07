<?php

namespace Zrcms\CorePage;

use Zrcms\CoreApplication\Api\ApiNoop;
use Zrcms\CoreContainer\Api\Render\GetContainerRenderTags;
use Zrcms\CoreContainer\Api\Render\RenderContainer;
use Zrcms\CorePage\Api\CmsResource\UpsertPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageDraftCmsResource;
use Zrcms\CorePage\Api\CmsResource\UpsertPageTemplateCmsResource;
use Zrcms\CorePage\Api\Render\GetPageRenderTags;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsBasic;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsContainers;
use Zrcms\CorePage\Api\Render\GetPageRenderTagsHtml;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResource;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageCmsResourcesBy;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourceBySitePath;
use Zrcms\CorePage\Api\CmsResource\FindPageTemplateCmsResourcesBy;
use Zrcms\CorePage\Api\Content\FindPageVersion;
use Zrcms\CorePage\Api\Content\FindPageVersionsBy;
use Zrcms\CorePage\Api\Content\InsertPageVersion;
use Zrcms\CorePage\Model\ServiceAliasPage;
use Zrcms\ServiceAlias\Api\GetServiceFromAlias;

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
                    UpsertPageCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertPageCmsResource::class],
                        ],
                    ],
                    UpsertPageTemplateCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertPageTemplateCmsResource::class],
                        ],
                    ],
                    UpsertPageDraftCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => UpsertPageDraftCmsResource::class],
                        ],
                    ],
                    GetPageRenderTags::class => [
                        'class' => GetPageRenderTagsBasic::class,
                        'arguments' => [
                            '0-' => GetServiceFromAlias::class,
                        ],
                    ],
                    GetPageRenderTagsHtml::class => [],
                    GetPageRenderTagsContainers::class => [
                        'arguments' => [
                            '0-' => GetContainerRenderTags::class,
                            '1-' => RenderContainer::class,
                        ],
                    ],
                    FindPageCmsResource::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageCmsResource::class],
                        ],
                    ],
                    FindPageCmsResourceBySitePath::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageCmsResourceBySitePath::class],
                        ],
                    ],
                    FindPageCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageCmsResourcesBy::class],
                        ],
                    ],
                    FindPageVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageVersion::class],
                        ],
                    ],
                    FindPageVersionsBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageVersionsBy::class],
                        ],
                    ],
                    FindPageTemplateCmsResourceBySitePath::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageTemplateCmsResourceBySitePath::class],
                        ],
                    ],
                    FindPageTemplateCmsResourcesBy::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => FindPageTemplateCmsResourcesBy::class],
                        ],
                    ],
                    InsertPageVersion::class => [
                        'class' => ApiNoop::class,
                        'arguments' => [
                            '0-' => ['literal' => InsertPageVersion::class],
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.page.content.render-tags-getter'
                ServiceAliasPage::ZRCMS_CONTENT_RENDER_TAGS_GETTER => [
                    'containers'
                    => GetPageRenderTagsContainers::class,

                    'html'
                    => GetPageRenderTagsHtml::class,
                ],
            ],
        ];
    }
}