<?php

namespace Zrcms\HttpExpressive1\HttpRender;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImplementationTest
{
    public function __construct(
        array $tests
    ) {
        $this->tests = [
            'NAME' => [
                'components' => [],
                'cmsResource' => [
                    'content' => [],
                ],
            ]
        ];
    }

    /**
     * __invoke
     *
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

        /* @todo Write this
            - for each content type (Container with block, PageContainer, Site, ThemeLayout, View)
            - Get components
            - create content
            - publish content
            - unpublish content
            - re-publish content
            - find resource and version
         */

    }
}
