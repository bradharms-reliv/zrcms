<?php

namespace Zrcms\ContentRedirectDoctrineDataSource\Api\Repository;

use Doctrine\ORM\EntityManager;
use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Api\BasicCmsResourceTrait;
use Zrcms\ContentRedirect\Model\PropertiesRedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResource;
use Zrcms\ContentRedirect\Model\RedirectCmsResourceBasic;
use Zrcms\ContentRedirectDoctrineDataSource\Entity\RedirectCmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindRedirectCmsResourceBySiteRequestPath
    implements \Zrcms\ContentRedirect\Api\Repository\FindRedirectCmsResourceBySiteRequestPath
{
    use BasicCmsResourceTrait;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var string
     */
    protected $entityClassCmsResource;

    /**
     * @var
     */
    protected $classCmsResourceBasic;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->entityClassCmsResource = RedirectCmsResourceEntity::class;
        $this->classCmsResourceBasic = RedirectCmsResourceBasic::class;
    }

    /**
     * @param string $siteCmsResourceId
     * @param string $requestPath
     * @param array  $options
     *
     * @return RedirectCmsResource|CmsResource|null
     * @throws CmsResourceNotExistsException
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $requestPath,
        array $options = []
    ) {
        $siteCmsResourceIdPropertyName = PropertiesRedirectCmsResource::SITE_CMS_RESOURCE_ID;
        $requestPathPropertyName = PropertiesRedirectCmsResource::REQUEST_PATH;
        $publishedPropertyName = PropertiesRedirectCmsResource::PUBLISHED;

        // @todo Add prepared statements not concat
        $query = ""
            . "SELECT resource FROM {$this->entityClassCmsResource} resource"
            . " WHERE (resource.{$siteCmsResourceIdPropertyName} = :siteCmsResource"
            . " OR resource.{$siteCmsResourceIdPropertyName} IS NULL)"
            . " AND resource.{$requestPathPropertyName} = :requestPath"
            . " AND resource.{$publishedPropertyName} = true"
            . " ORDER BY resource.{$siteCmsResourceIdPropertyName} ASC";

        $dQuery = $this->entityManager->createQuery($query);

        $dQuery->setParameter('siteCmsResource', $siteCmsResourceId);
        $dQuery->setParameter('requestPath', $requestPath);
        $dQuery->setMaxResults(1);

        $result = $dQuery->getResult();

        if (empty($result)) {
            return null;
        }

        return $this->newBasicCmsResource(
            $this->entityClassCmsResource,
            $this->classCmsResourceBasic,
            $result[0]
        );
    }
}
