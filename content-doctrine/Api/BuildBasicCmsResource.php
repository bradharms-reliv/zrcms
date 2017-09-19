<?php

namespace Zrcms\ContentDoctrine\Api;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildBasicCmsResource
{
    /**
     * @param string                 $entityClassCmsResource
     * @param string                 $classCmsResourceBasic
     * @param string                 $entityClassContentVersion
     * @param string                 $classContentVersionBasic
     * @param CmsResourceEntity|null $cmsResourceEntity
     * @param array                  $cmsResourceSyncToProperties
     * @param array                  $contentVersionSyncToProperties
     *
     * @return CmsResource
     * @throws \Exception
     */
    public static function invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $cmsResourceEntity,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        if (empty($cmsResourceEntity)) {
            return null;
        }

        if (!is_a($entityClassCmsResource, CmsResourceEntity::class, true)) {
            throw new \Exception(
                'Entity class must be of type: ' . CmsResourceEntity::class
            );
        }

        if (!is_a($classCmsResourceBasic, CmsResource::class, true)) {
            throw new \Exception(
                'Class basic must be of type: ' . CmsResource::class
            );
        }

        if (!is_a($cmsResourceEntity, $entityClassCmsResource)) {
            throw new \Exception(
                'Entity must be of type: ' . $entityClassCmsResource . ' got: ' . get_class($cmsResourceEntity)
            );
        }

        if (!is_a($cmsResourceEntity, CmsResourceEntity::class)) {
            throw new \Exception(
                'Entity must be of type: ' . CmsResourceEntity::class . ' got: ' . get_class($cmsResourceEntity)
            );
        }

        $properties = ExtractCmsResourceEntityProperties::invoke(
            $cmsResourceEntity,
            $cmsResourceSyncToProperties
        );

        $contentVersion = BuildBasicContentVersion::invoke(
            $entityClassContentVersion,
            $classContentVersionBasic,
            $cmsResourceEntity->getContentVersion(),
            $contentVersionSyncToProperties
        );

        $new = new $classCmsResourceBasic(
            $cmsResourceEntity->getId(),
            $cmsResourceEntity->isPublished(),
            $contentVersion,
            $properties,
            $cmsResourceEntity->getCreatedByUserId(),
            $cmsResourceEntity->getCreatedReason()
        );

        return $new;
    }

    /**
     * @param string                 $entityClassCmsResource
     * @param string                 $classCmsResourceBasic
     * @param string                 $entityClassContentVersion
     * @param string                 $classContentVersionBasic
     * @param CmsResourceEntity|null $cmsResourceEntity
     * @param array                  $cmsResourceSyncToProperties
     * @param array                  $contentVersionSyncToProperties
     *
     * @return CmsResource
     */
    public function __invoke(
        string $entityClassCmsResource,
        string $classCmsResourceBasic,
        string $entityClassContentVersion,
        string $classContentVersionBasic,
        $cmsResourceEntity,
        array $cmsResourceSyncToProperties = [],
        array $contentVersionSyncToProperties = []
    ) {
        return self::invoke(
            $entityClassCmsResource,
            $classCmsResourceBasic,
            $entityClassContentVersion,
            $classContentVersionBasic,
            $cmsResourceEntity,
            $cmsResourceSyncToProperties,
            $contentVersionSyncToProperties
        );
    }
}
