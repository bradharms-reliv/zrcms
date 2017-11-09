<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\Content\Model\ContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PageCmsResourceBasic extends PageCmsResourceAbstract implements PageCmsResource
{
    /**
     * @param null|string                $id
     * @param bool                       $published
     * @param PageVersion|ContentVersion $contentVersion
     * @param string                     $createdByUserId
     * @param string                     $createdReason
     * @param string|null                $createdDate
     */
    public function __construct(
        $id,
        bool $published,
        ContentVersion $contentVersion,
        string $createdByUserId,
        string $createdReason,
        string $createdDate = null
    ) {
        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $createdByUserId,
            $createdReason,
            $createdDate
        );
    }
}