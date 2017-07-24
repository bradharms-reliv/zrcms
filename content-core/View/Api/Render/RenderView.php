<?php

namespace Zrcms\ContentCore\View\Api\Render;

use Zrcms\Content\Api\Render\RenderContent;
use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\View\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderView extends RenderContent
{
    /**
     * @param View|Content $view
     * @param array        $renderData ['render-tag' => '{html}']
     * @param array        $options
     *
     * @return string
     */
    public function __invoke(
        Content $view,
        array $renderData,
        array $options = []
    ): string;
}