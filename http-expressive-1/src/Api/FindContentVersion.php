<?php

namespace Zrcms\HttpExpressive1\Api;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reliv\RcmApiLib\Http\PsrApiResponse;
use Reliv\RcmApiLib\Model\ApiMessage;
use Zrcms\Content\Api\ContentVersionToArray;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindContentVersion
{
    /**
     * @var \Zrcms\Content\Api\Repository\FindContentVersion
     */
    protected $findContentVersion;

    /**
     * @var ContentVersionToArray
     */
    protected $contentVersionToArray;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param \Zrcms\Content\Api\Repository\FindContentVersion $findContentVersion
     * @param ContentVersionToArray                            $contentVersionToArray
     * @param string                                           $name
     */
    public function __construct(
        \Zrcms\Content\Api\Repository\FindContentVersion $findContentVersion,
        ContentVersionToArray $contentVersionToArray,
        string $name
    ) {
        $this->findContentVersion = $findContentVersion;
        $this->contentVersionToArray = $contentVersionToArray;
        $this->name = $name;
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
        $contentVersionId = $request->getAttribute('id');

        if (empty($contentVersionId)) {
            return new PsrApiResponse(
                null,
                [
                    new ApiMessage(
                        $this->name,
                        'ID not received',
                        'find-content-version',
                        'id-not-received',
                        true
                    )
                ],
                400
            );
        }

        $contentVersion = $this->findContentVersion->__invoke(
            $contentVersionId
        );

        if (empty($contentVersion)) {
            return new PsrApiResponse(
                null,
                [
                    new ApiMessage(
                        $this->name,
                        'Not found for id: ' . $contentVersionId,
                        'find-content-version',
                        'not-found',
                        true
                    )
                ],
                404
            );
        }

        $result = $this->contentVersionToArray->__invoke(
            $contentVersion
        );

        return new PsrApiResponse(
            $result
        );
    }
}
