<?php

namespace Rcms\Core\Tracking\Model;

use Rcms\Core\Tracking\Exception\TrackingException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait TrackingTrait
{
    /**
     * <tracking>
     *
     * @var \DateTime Date object was first created
     */
    protected $createdDate;

    /**
     * <tracking>
     *
     * @var string User ID of creator
     */
    protected $createdByUserId;

    /**
     * <tracking>
     *
     * @var string Short description of create reason
     */
    protected $createdReason = Tracking::UNKNOWN_REASON;

    /**
     * <tracking>
     *
     * @var \DateTime Date object was modified
     */
    protected $modifiedDate;

    /**
     * <tracking>
     *
     * @var string User ID of modifier
     */
    protected $modifiedByUserId;

    /**
     * <tracking>
     *
     * @var string Short description of create reason
     */
    protected $modifiedReason = Tracking::UNKNOWN_REASON;

    /**
     * <tracking>
     *
     * @var bool Tracking that this value has been updated
     */
    protected $modifiedDateUpdated = false;

    /**
     * <tracking>
     *
     * @var bool Tracking that this value has been updated
     */
    protected $modifiedByUserIdUpdated = false;

    /**
     * Get a clone with special logic
     *
     * @param string $createdByUserId
     * @param string $createdReason
     *
     * @return static
     */
    public function newInstance(
        string $createdByUserId,
        string $createdReason = Tracking::UNKNOWN_REASON
    ) {
        $new = clone($this);
        // Reset the clone
        $new->createdByUserId = null;
        $new->createdDate = null;
        $new->createdReason = Tracking::UNKNOWN_REASON;

        $new->setCreatedByUserId(
            $createdByUserId,
            $createdReason
        );

        return $new;
    }

    /**
     * <tracking>
     *
     * @return \DateTime
     * @throws TrackingException
     */
    public function getCreatedDate(): \DateTime
    {
        // not set
        if (empty($this->createdDate)) {
            throw new TrackingException('Value not set for createdDate in ' . get_class($this));
        }

        return $this->createdDate;
    }

    /**
     * <tracking>
     *
     * @return string
     * @throws TrackingException
     */
    public function getCreatedByUserId(): string
    {
        // not set
        if (empty($this->createdByUserId)) {
            throw new TrackingException('Value not set for createdByUserId in ' . get_class($this));
        }

        return $this->createdByUserId;
    }

    /**
     * <tracking>
     *
     * @return string
     */
    public function getCreatedReason(): string
    {
        return $this->createdReason;
    }

    /**
     * @todo this should be protected
     * <tracking> WARNING: this should only be used on creation
     *
     * @param string $createdByUserId
     * @param string $createdReason
     *
     * @return void
     * @throws TrackingException
     */
    public function setCreatedByUserId(
        string $createdByUserId,
        string $createdReason = Tracking::UNKNOWN_REASON
    ) {
        // invalid
        if (strlen($createdByUserId) < 1) {
            throw new TrackingException('Invalid createdByUserId in ' . get_class($this));
        }

        // already set
        if (!empty($this->createdByUserId)) {
            throw new TrackingException('Can not change createdByUserId in ' . get_class($this));
        }

        $this->createdByUserId = $createdByUserId;

        // already set
        if (!empty($this->createdDate)) {
            throw new TrackingException('Can not change createdDate in ' . get_class($this));
        }

        $this->createdDate = new \DateTime();
        $this->createdReason = $createdReason;

        $this->setModifiedByUserId(
            $createdByUserId,
            $createdReason
        );
    }

    /**
     * <tracking>
     *
     * @return \DateTime
     * @throws TrackingException
     */
    public function getModifiedDate(): \DateTime
    {
        // not set
        if (empty($this->modifiedDate)) {
            throw new TrackingException('Value not set for modifiedDate in ' . get_class($this));
        }

        return $this->modifiedDate;
    }

    /**
     * <tracking>
     *
     * @return string
     * @throws TrackingException
     */
    public function getModifiedByUserId(): string
    {
        // not set
        if (empty($this->modifiedByUserId)) {
            throw new TrackingException('Value not set for modifiedByUserId in ' . get_class($this));
        }

        return $this->modifiedByUserId;
    }

    /**
     * <tracking>
     *
     * @return string
     */
    public function getModifiedReason(): string
    {
        return $this->modifiedReason;
    }

    /**
     * <tracking>
     *
     * @param string $modifiedByUserId
     * @param string $modifiedReason
     *
     * @return void
     * @throws TrackingException
     */
    public function setModifiedByUserId(
        string $modifiedByUserId,
        string $modifiedReason = Tracking::UNKNOWN_REASON
    ) {
        // invalid
        if (strlen($modifiedByUserId) < 1) {
            throw new TrackingException('Invalid modifiedByUserId in ' . get_class($this));
        }

        $this->modifiedByUserIdUpdated = true;
        $this->modifiedByUserId = $modifiedByUserId;

        $this->modifiedDate = new \DateTime();

        $this->modifiedReason = $modifiedReason;
    }

    /**
     * <tracking>
     *
     * @return void
     * @throws TrackingException
     */
    public function assertHasTrackingData()
    {
        if (empty($this->createdDate)) {
            throw new TrackingException('Value not set for createdDate in ' . get_class($this));
        }

        if (empty($this->createdByUserId)) {
            throw new TrackingException('Value not set for createdByUserId in ' . get_class($this));
        }

        if (empty($this->modifiedByUserId)) {
            throw new TrackingException('Value not set for modifiedByUserId in ' . get_class($this));
        }

        if (empty($this->modifiedDate)) {
            throw new TrackingException('Value not set for modifiedDate in ' . get_class($this));
        }
    }

    /**
     * <tracking>
     *
     * @return void
     * @throws TrackingException
     */
    public function assertHasNewModifiedData()
    {
        if (!$this->modifiedByUserIdUpdated) {
            throw new TrackingException('Modified data has not been updated in ' . get_class($this));
        }

        $this->assertHasTrackingData();
    }
}
