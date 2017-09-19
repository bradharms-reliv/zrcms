<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Page\Entity;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Exception\PropertyMissingException;
use Zrcms\ContentCore\Page\Fields\FieldsPageContainerCmsResource;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_container_resource",
 *     indexes={
 *        @ORM\Index(name="contentVersionId", columns={"contentVersionId"}),
 *        @ORM\Index(name="siteCmsResourceId", columns={"siteCmsResourceId"}),
 *        @ORM\Index(name="path", columns={"path"})
 *     }
 * )
 */
class PageContainerCmsResourceEntity
    extends CmsResourceEntityAbstract
    implements CmsResourceEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean")
     */
    protected $published = true;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $contentVersionId = null;

    /**
     * @var PageContainerVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="PageContainerVersionEntity")
     * @ORM\JoinColumn(
     *     name="contentVersionId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $contentVersion;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

    /**
     * Date object was first created mapped to col createdDate
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="createdDate")
     */
    protected $createdDateObject;

    /**
     * User ID of creator
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $createdReason;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $siteCmsResourceId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $path;

    /**
     * @param int|null                                 $id
     * @param bool                                     $published
     * @param PageContainerVersionEntity|ContentEntity $contentVersion
     * @param array                                    $properties
     * @param string                                   $createdByUserId
     * @param string                                   $createdReason
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentVersion,
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        $this->setProperties($properties);

        parent::__construct(
            $id,
            $published,
            $contentVersion,
            $properties,
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * @return string
     */
    public function getSiteCmsResourceId(): string
    {
        return $this->siteCmsResourceId;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param array $properties
     *
     * @return void
     */
    public function setProperties(
        array $properties
    ) {
        Param::assertHas(
            $properties,
            FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID,
            PropertyMissingException::buildThrower(
                FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID,
                $properties,
                get_class($this)
            )
        );

        $this->siteCmsResourceId = Param::getString(
            $properties,
            FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID,
            ''
        );

        Param::assertHas(
            $properties,
            FieldsPageContainerCmsResource::PATH,
            PropertyMissingException::buildThrower(
                FieldsPageContainerCmsResource::PATH,
                $properties,
                get_class($this)
            )
        );

        $this->path = Param::getString(
            $properties,
            FieldsPageContainerCmsResource::PATH,
            ''
        );

        parent::setProperties($properties);
    }

    /**
     * @return void
     *
     * @ORM\PostPersist
     */
    public function postPersist(LifecycleEventArgs $event)
    {
        $this->properties[FieldsPageContainerCmsResource::SITE_CMS_RESOURCE_ID] = $this->siteCmsResourceId;
        $this->properties[FieldsPageContainerCmsResource::PATH] = $this->path;
    }
}
