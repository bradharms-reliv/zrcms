<?php

namespace Zrcms\HttpApi\Validate;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Stdlib\ResponseInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateParamQueryDynamic
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface      $response
     * @param callable|null          $next
     *
     * @return ResponseInterface
     * @throws \Exception
     */
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) {
        // @todo Write this
        return $next($request, $response);
    }
}
