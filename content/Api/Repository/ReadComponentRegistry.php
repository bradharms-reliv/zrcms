<?php

namespace Zrcms\Content\Api\Repository;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ReadComponentRegistry
{
    /**
     * @param array $options
     *
     * @return array
     */
    public function __invoke(
        array $options = []
    ): array;
}
