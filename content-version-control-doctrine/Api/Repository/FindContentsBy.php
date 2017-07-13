<?php

namespace Zrcms\ContentVersionControlDoctrine\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
abstract class FindContentsBy implements \Zrcms\ContentVersionControl\Api\Repository\FindContentsBy
{
    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return array [Content]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {

    }
}
