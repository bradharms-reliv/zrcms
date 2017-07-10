<?php

namespace Zrcms\Core\Layout\Api;

use Zrcms\Core\Layout\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContainerPathsByHtmlMustache implements FindContainerPathsByHtml
{
    /**
     * @param string $html
     * @param array  $options
     *
     * @return array ['{container-name}']
     */
    public function __invoke(string $html, array $options = [])
    {
        // @todo write me
        return [];
    }
}
