<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/cloudcontrolspartner/v1beta/access_approval_requests.proto

namespace Google\Cloud\CloudControlsPartner\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Reason for the access.
 *
 * Generated from protobuf message <code>google.cloud.cloudcontrolspartner.v1beta.AccessReason</code>
 */
class AccessReason extends \Google\Protobuf\Internal\Message
{
    /**
     * Type of access justification.
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.AccessReason.Type type = 1;</code>
     */
    protected $type = 0;
    /**
     * More detail about certain reason types. See comments for each type above.
     *
     * Generated from protobuf field <code>string detail = 2;</code>
     */
    protected $detail = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $type
     *           Type of access justification.
     *     @type string $detail
     *           More detail about certain reason types. See comments for each type above.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Cloudcontrolspartner\V1Beta\AccessApprovalRequests::initOnce();
        parent::__construct($data);
    }

    /**
     * Type of access justification.
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.AccessReason.Type type = 1;</code>
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Type of access justification.
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.AccessReason.Type type = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setType($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\CloudControlsPartner\V1beta\AccessReason\Type::class);
        $this->type = $var;

        return $this;
    }

    /**
     * More detail about certain reason types. See comments for each type above.
     *
     * Generated from protobuf field <code>string detail = 2;</code>
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * More detail about certain reason types. See comments for each type above.
     *
     * Generated from protobuf field <code>string detail = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setDetail($var)
    {
        GPBUtil::checkString($var, True);
        $this->detail = $var;

        return $this;
    }

}

