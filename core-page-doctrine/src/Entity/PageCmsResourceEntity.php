<?php

namespace Zrcms\CorePageDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Core\Exception\ContentVersionInvalid;
use Zrcms\CorePage\Api\AssertValidPath;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntity;
use Zrcms\CoreApplicationDoctrine\Entity\CmsResourceEntityAbstract;
use Zrcms\CoreApplicationDoctrine\Entity\ContentEntity;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_page_resource",
 *     indexes={
 *        @ORM\Index(name="contentVersionId", columns={"contentVersionId"}),
 *        @ORM\Index(name="siteCmsResourceId", columns={"siteCmsResourceId"}),
 *        @ORM\Index(name="path", columns={"path"})
 *     },
 *     uniqueConstraints={@ORM\UniqueConstraint(name="page_unique",columns={"siteCmsResourceId","path"})}
 * )
 */
class PageCmsResourceEntity extends CmsResourceEntityAbstract implements CmsResourceEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="string")
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
     * @ORM\Column(type="string", nullable=true)
     */
    protected $contentVersionId = null;

    /**
     * @var PageVersionEntity
     *
     * @ORM\ManyToOne(targetEntity="PageVersionEntity")
     * @ORM\JoinColumn(
     *     name="contentVersionId",
     *     referencedColumnName="id",
     *     onDelete="SET NULL"
     * )
     */
    protected $contentVersion;

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
     * Date object was first created mapped to col createdDate
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="createdDate")
     */
    protected $createdDateObject;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $modifiedByUserId;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $modifiedReason;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="modifiedDateDate")
     */
    protected $modifiedDateObject;

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
     * @param int|null                        $id
     * @param bool                            $published
     * @param PageVersionEntity|ContentEntity $contentVersion
     * @param string                          $createdByUserId
     * @param string                          $createdReason
     * @param string|null                     $createdDate
     *
     * @throws \Zrcms\Core\Exception\TrackingInvalid
     */
    public function __construct(
        $id,
        bool $published,
        ContentEntity $contentVersion,
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
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
     * @param PageVersionEntity|ContentEntity $contentVersion
     * @param string                          $modifiedByUserId
     * @param string                          $modifiedReason
     * @param string|null                     $modifiedDate
     *
     * @return void
     */
    public function setContentVersion(
        ContentEntity $contentVersion,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ) {
        $this->siteCmsResourceId = $contentVersion->getSiteCmsResourceId();
        $this->path = $contentVersion->getPath();

        parent::setContentVersion(
            $contentVersion,
            $modifiedByUserId,
            $modifiedReason,
            $modifiedDate
        );
    }

    /**
     * @param PageVersionEntity $contentVersion
     *
     * @return void
     * @throws ContentVersionInvalid
     * @throws \Zrcms\CorePage\Exception\InvalidPath
     */
    protected function assertValidContentVersion($contentVersion)
    {
        if (!$contentVersion instanceof PageVersionEntity) {
            throw new ContentVersionInvalid(
                'ContentVersion must be instance of: ' . PageVersionEntity::class
                . ' got: ' . var_export($contentVersion, true)
                . ' for: ' . get_class($this)
            );
        }

        if (empty($contentVersion->getSiteCmsResourceId())) {
            throw new ContentVersionInvalid(
                'SiteCmsResourceId can not be empty'
            );
        }

        if (empty($contentVersion->getPath())) {
            throw new ContentVersionInvalid(
                'Path can not be empty'
            );
        }

        AssertValidPath::invoke($contentVersion->getPath());
    }
}
