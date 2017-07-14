<?php

namespace Zrcms\Core\Page\Api\Repository;

use Zrcms\ContentVersionControl\Api\Repository\FindContentsBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindPagesBy extends FindContentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null|int   $limit
     * @param null|int   $offset
     * @param array      $options
     *
     * @return array [Page]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array;
}