<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceAbstract;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntity;
use Zrcms\ContentDoctrine\Entity\CmsResourceEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_layout_resource",
 *     indexes={}
 * )
 */
class LayoutCmsResourceEntity
    extends LayoutCmsResourceAbstract
    implements LayoutCmsResource, CmsResourceEntity
{
    use CmsResourceEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $contentVersionId = null;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    protected $properties = [];

    /**
     * Date object was first created
     *
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $createdDate;

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
     * @param array  $properties
     * @param string $createdByUserId
     * @param string $createdReason
     */
    public function __construct(
        array $properties,
        string $createdByUserId,
        string $createdReason
    ) {
        // Force Id to int
        $properties[PropertiesCmsResource::ID] = Param::getInt(
            $properties,
            PropertiesCmsResource::ID
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}