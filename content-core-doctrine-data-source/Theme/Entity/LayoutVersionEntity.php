<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zrcms\Content\Model\PropertiesContent;
use Zrcms\ContentCore\Theme\Model\LayoutVersion;
use Zrcms\ContentCore\Theme\Model\LayoutVersionAbstract;
use Zrcms\ContentDoctrine\Entity\ContentEntity;
use Zrcms\ContentDoctrine\Entity\ContentEntityTrait;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 *
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="zrcms_core_layout_version",
 *     indexes={}
 * )
 */
class LayoutVersionEntity
    extends LayoutVersionAbstract
    implements LayoutVersion, ContentEntity
{
    use ContentEntityTrait;

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;

    /**
     *
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
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $html;

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
        $properties[PropertiesContent::ID] = Param::getInt(
            $properties,
            PropertiesContent::ID
        );

        parent::__construct(
            $properties,
            $createdByUserId,
            $createdReason
        );
    }
}