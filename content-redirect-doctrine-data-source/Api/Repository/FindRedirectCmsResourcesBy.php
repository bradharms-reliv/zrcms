<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;
use Zrcms\ContentDoctrine\Api\Repository\FindCmsResourcesBy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResourcesBy
    extends FindCmsResourcesBy
    implements \Zrcms\Content\Api\Repository\FindCmsResourcesBy
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct(
            $entityManager,
            RedirectCmsResourceEntity::class,
            RedirectCmsResourceBasic::class
        );
    }

    /**
     * @param array      $criteria
     * @param array|null $orderBy
     * @param null       $limit
     * @param null       $offset
     * @param array      $options
     *
     * @return RedirectCmsResource[]
     */
    public function __invoke(
        array $criteria,
        array $orderBy = null,
        $limit = null,
        $offset = null,
        array $options = []
    ): array
    {
        return parent::__invoke(
            $criteria,
            $orderBy,
            $limit,
            $offset,
            $options
        );
    }
}