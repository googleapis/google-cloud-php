<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The status of one Attachment in the group. List order is arbitrary.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.InterconnectAttachmentGroupsOperationalStatusAttachmentStatus</code>
 */
class InterconnectAttachmentGroupsOperationalStatusAttachmentStatus extends \Google\Protobuf\Internal\Message
{
    /**
     * Whether this Attachment is enabled. This becomes false when the customer drains their Attachment.
     *
     * Generated from protobuf field <code>optional bool admin_enabled = 445675089;</code>
     */
    private $admin_enabled = null;
    /**
     * The URL of the Attachment being described.
     *
     * Generated from protobuf field <code>optional string attachment = 183982371;</code>
     */
    private $attachment = null;
    /**
     * Whether this Attachment is participating in the redundant configuration. This will be ACTIVE if and only if the status below is CONNECTION_UP. Any INACTIVE Attachments are excluded from the analysis that generates operational.availabilitySLA.
     * Check the IsActive enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string is_active = 114830267;</code>
     */
    private $is_active = null;
    /**
     * Whether this Attachment is active, and if so, whether BGP is up. This is based on the statuses available in the Pantheon UI here: http://google3/java/com/google/cloud/boq/clientapi/gce/hybrid/api/interconnect_models.proto
     * Check the Status enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string status = 181260274;</code>
     */
    private $status = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $admin_enabled
     *           Whether this Attachment is enabled. This becomes false when the customer drains their Attachment.
     *     @type string $attachment
     *           The URL of the Attachment being described.
     *     @type string $is_active
     *           Whether this Attachment is participating in the redundant configuration. This will be ACTIVE if and only if the status below is CONNECTION_UP. Any INACTIVE Attachments are excluded from the analysis that generates operational.availabilitySLA.
     *           Check the IsActive enum for the list of possible values.
     *     @type string $status
     *           Whether this Attachment is active, and if so, whether BGP is up. This is based on the statuses available in the Pantheon UI here: http://google3/java/com/google/cloud/boq/clientapi/gce/hybrid/api/interconnect_models.proto
     *           Check the Status enum for the list of possible values.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * Whether this Attachment is enabled. This becomes false when the customer drains their Attachment.
     *
     * Generated from protobuf field <code>optional bool admin_enabled = 445675089;</code>
     * @return bool
     */
    public function getAdminEnabled()
    {
        return isset($this->admin_enabled) ? $this->admin_enabled : false;
    }

    public function hasAdminEnabled()
    {
        return isset($this->admin_enabled);
    }

    public function clearAdminEnabled()
    {
        unset($this->admin_enabled);
    }

    /**
     * Whether this Attachment is enabled. This becomes false when the customer drains their Attachment.
     *
     * Generated from protobuf field <code>optional bool admin_enabled = 445675089;</code>
     * @param bool $var
     * @return $this
     */
    public function setAdminEnabled($var)
    {
        GPBUtil::checkBool($var);
        $this->admin_enabled = $var;

        return $this;
    }

    /**
     * The URL of the Attachment being described.
     *
     * Generated from protobuf field <code>optional string attachment = 183982371;</code>
     * @return string
     */
    public function getAttachment()
    {
        return isset($this->attachment) ? $this->attachment : '';
    }

    public function hasAttachment()
    {
        return isset($this->attachment);
    }

    public function clearAttachment()
    {
        unset($this->attachment);
    }

    /**
     * The URL of the Attachment being described.
     *
     * Generated from protobuf field <code>optional string attachment = 183982371;</code>
     * @param string $var
     * @return $this
     */
    public function setAttachment($var)
    {
        GPBUtil::checkString($var, True);
        $this->attachment = $var;

        return $this;
    }

    /**
     * Whether this Attachment is participating in the redundant configuration. This will be ACTIVE if and only if the status below is CONNECTION_UP. Any INACTIVE Attachments are excluded from the analysis that generates operational.availabilitySLA.
     * Check the IsActive enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string is_active = 114830267;</code>
     * @return string
     */
    public function getIsActive()
    {
        return isset($this->is_active) ? $this->is_active : '';
    }

    public function hasIsActive()
    {
        return isset($this->is_active);
    }

    public function clearIsActive()
    {
        unset($this->is_active);
    }

    /**
     * Whether this Attachment is participating in the redundant configuration. This will be ACTIVE if and only if the status below is CONNECTION_UP. Any INACTIVE Attachments are excluded from the analysis that generates operational.availabilitySLA.
     * Check the IsActive enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string is_active = 114830267;</code>
     * @param string $var
     * @return $this
     */
    public function setIsActive($var)
    {
        GPBUtil::checkString($var, True);
        $this->is_active = $var;

        return $this;
    }

    /**
     * Whether this Attachment is active, and if so, whether BGP is up. This is based on the statuses available in the Pantheon UI here: http://google3/java/com/google/cloud/boq/clientapi/gce/hybrid/api/interconnect_models.proto
     * Check the Status enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string status = 181260274;</code>
     * @return string
     */
    public function getStatus()
    {
        return isset($this->status) ? $this->status : '';
    }

    public function hasStatus()
    {
        return isset($this->status);
    }

    public function clearStatus()
    {
        unset($this->status);
    }

    /**
     * Whether this Attachment is active, and if so, whether BGP is up. This is based on the statuses available in the Pantheon UI here: http://google3/java/com/google/cloud/boq/clientapi/gce/hybrid/api/interconnect_models.proto
     * Check the Status enum for the list of possible values.
     *
     * Generated from protobuf field <code>optional string status = 181260274;</code>
     * @param string $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkString($var, True);
        $this->status = $var;

        return $this;
    }

}

