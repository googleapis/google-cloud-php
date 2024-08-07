<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/accessapproval/v1/accessapproval.proto

namespace Google\Cloud\AccessApproval\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request to get access approval settings.
 *
 * Generated from protobuf message <code>google.cloud.accessapproval.v1.GetAccessApprovalSettingsMessage</code>
 */
class GetAccessApprovalSettingsMessage extends \Google\Protobuf\Internal\Message
{
    /**
     * The name of the AccessApprovalSettings to retrieve.
     * Format: "{projects|folders|organizations}/{id}/accessApprovalSettings"
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.resource_reference) = {</code>
     */
    protected $name = '';

    /**
     * @param string $name The name of the AccessApprovalSettings to retrieve.
     *                     Format: "{projects|folders|organizations}/{id}/accessApprovalSettings"
     *
     * @return \Google\Cloud\AccessApproval\V1\GetAccessApprovalSettingsMessage
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           The name of the AccessApprovalSettings to retrieve.
     *           Format: "{projects|folders|organizations}/{id}/accessApprovalSettings"
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Accessapproval\V1\Accessapproval::initOnce();
        parent::__construct($data);
    }

    /**
     * The name of the AccessApprovalSettings to retrieve.
     * Format: "{projects|folders|organizations}/{id}/accessApprovalSettings"
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * The name of the AccessApprovalSettings to retrieve.
     * Format: "{projects|folders|organizations}/{id}/accessApprovalSettings"
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

}

