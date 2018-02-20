<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CoreView\Exception\InvalidGetViewByRequest;
use Zrcms\CoreView\Exception\ViewDataNotFound;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetViewByRequest
{
    const VIEW_PROPERTY_GET_VIEW_API_NAME = 'get-view-api-name';

    /**
     * @param ServerRequestInterface $request
     * @param array                  $options
     *
     * @return View
     * @throws ViewDataNotFound|InvalidGetViewByRequest
     */
    public function __invoke(
        ServerRequestInterface $request,
        array $options = []
    ): View;
}
