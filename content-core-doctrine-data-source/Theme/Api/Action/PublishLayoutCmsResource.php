<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Action;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceBasic;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourceEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutCmsResourcePublishHistoryEntity;
use Zrcms\ContentCoreDoctrineDataSource\Theme\Entity\LayoutVersionEntity;
use Zrcms\ContentDoctrine\Api\Action\PublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PublishLayoutCmsResource
    extends PublishCmsResource
    implements \Zrcms\ContentCore\Layout\Api\Action\PublishLayoutCmsResource
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(
        EntityManager $entityManager
    ) {
        parent::__construct(
            $entityManager,
            LayoutCmsResourceEntity::class,
            LayoutCmsResourcePublishHistoryEntity::class,
            LayoutVersionEntity::class,
            LayoutCmsResourceBasic::class
        );
    }

    /**
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource
    {
        return parent::__invoke(
            $layoutCmsResource,
            $publishedByUserId,
            $publishReason
        );
    }
}