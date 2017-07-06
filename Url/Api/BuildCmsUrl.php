<?php

namespace Rcms\Core\Url\Api;

use Rcms\Core\Url\Model\Schema;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildCmsUrl
{
    /**
     * @param string $siteId
     * @param string $type
     * @param string $path
     * @param array  $options
     * @param string $format
     *
     * @return mixed|string
     */
    public static function __invoke(
        string $siteId,
        string $type,
        string $path,
        array $options = [],
        $format = Schema::FORMAT
    ): string;
}
