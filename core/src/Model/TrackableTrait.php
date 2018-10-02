<?php

namespace Zrcms\Core\Model;

use Zrcms\Core\Exception\TrackingInvalid;

/**
 * @author James Jervis - https://github.com/jerv13
 */
trait TrackableTrait
{
    /**
     * Date object was first created
     *
     * @var string
     */
    protected $createdDate;

    /**
     * Date object was first created
     * NOTE: this is for internal use ONLY
     *
     * @var \DateTime
     */
    protected $createdDateObject;

    /**
     * User ID of creator
     *
     * @var string
     */
    protected $createdByUserId;

    /**
     * Short description of create reason
     *
     * @var string
     */
    protected $createdReason;

    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getCreatedDate(): string
    {
        if (empty($this->createdDate)) {
            throw new TrackingInvalid(
                'Value not set for createdDate in ' . get_class($this)
            );
        }

        return $this->createdDate;
    }

    /**
     * @return int
     * @throws TrackingInvalid
     */
    public function getCreatedTimestamp(): int
    {
        return $this->getCreatedDateObject()->format(Trackable::DATE_FORMAT_TIMESTAMP);
    }

    /**
     * @return \DateTime
     * @throws TrackingInvalid
     */
    public function getCreatedDateObject(): \DateTime
    {
        if (empty($this->createdDateObject)) {
            throw new TrackingInvalid(
                'Value not set for createdDateObject in ' . get_class($this)
            );
        }

        return $this->createdDateObject;
    }

    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getCreatedByUserId(): string
    {
        if (empty($this->createdByUserId)) {
            throw new TrackingInvalid(
                'Value not set for createdByUserId in ' . get_class($this)
            );
        }

        return $this->createdByUserId;
    }

    /**
     * @return string
     * @throws TrackingInvalid
     */
    public function getCreatedReason(): string
    {
        if (empty($this->createdReason)) {
            throw new TrackingInvalid(
                'Value not set for createdReason in ' . get_class($this)
            );
        }

        return $this->createdReason;
    }

    /**
     * @return bool
     */
    public function hasCreatedData()
    {
        return (!empty($this->createdDate) && !empty($this->createdByUserId) && empty($this->createdReason));
    }

    /**
     * @return void
     * @throws TrackingInvalid
     */
    public function assertHasCreatedData()
    {
        if (empty($this->createdDate)) {
            throw new TrackingInvalid(
                'Value not set for createdDate in ' . get_class($this)
            );
        }

        if (empty($this->createdByUserId)) {
            throw new TrackingInvalid(
                'Value not set for createdByUserId in ' . get_class($this)
            );
        }

        if (empty($this->createdReason)) {
            throw new TrackingInvalid(
                'Value not set for createdReason in ' . get_class($this)
            );
        }
    }

    /**
     * @param string      $createdByUserId
     * @param string      $createdReason
     * @param string|null $createdDate
     *
     * @return void
     * @throws TrackingInvalid
     */
    protected function setCreatedData(
        string $createdByUserId,
        string $createdReason,
        $createdDate = null
    ) {
        // invalid
        if (empty($createdByUserId)) {
            throw new TrackingInvalid(
                'Invalid createdByUserId in ' . get_class($this)
            );
        }

        if (empty($createdReason)) {
            throw new TrackingInvalid(
                'Invalid createdReason in ' . get_class($this)
            );
        }

        if (!empty($this->createdByUserId)) {
            throw new TrackingInvalid(
                'Can not change createdByUserId in ' . get_class($this)
            );
        }

        $this->createdByUserId = $createdByUserId;

        if (!empty($this->createdDate)) {
            throw new TrackingInvalid(
                'Can not change createdDate in ' . get_class($this)
            );
        }

        // ALWAYS STORE UTC
        $timezone = new \DateTimeZone('UTC');

        if (!is_string($createdDate)) {
            $createdDateObject = new \DateTime(
                'now',
                $timezone
            );
        } else {
            $createdDateObject = \DateTime::createFromFormat(
                Trackable::DATE_FORMAT,
                $createdDate,
                $timezone
            );
        }
        
        $this->createdDateObject = $createdDateObject;

        $this->createdDate = $createdDateObject->format(Trackable::DATE_FORMAT);
        $this->createdReason = $createdReason;
    }

    /**
     * @return void
     * @throws TrackingInvalid
     */
    public function __clone()
    {
        throw new TrackingInvalid(
            'Cloning of tracking objects is not supported in ' . get_class($this)
        );
    }
}
