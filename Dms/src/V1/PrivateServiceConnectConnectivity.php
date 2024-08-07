<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/clouddms/v1/clouddms_resources.proto

namespace Google\Cloud\CloudDms\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * [Private Service Connect
 * connectivity](https://cloud.google.com/vpc/docs/private-service-connect#service-attachments)
 *
 * Generated from protobuf message <code>google.cloud.clouddms.v1.PrivateServiceConnectConnectivity</code>
 */
class PrivateServiceConnectConnectivity extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. A service attachment that exposes a database, and has the
     * following format:
     * projects/{project}/regions/{region}/serviceAttachments/{service_attachment_name}
     *
     * Generated from protobuf field <code>string service_attachment = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $service_attachment = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $service_attachment
     *           Required. A service attachment that exposes a database, and has the
     *           following format:
     *           projects/{project}/regions/{region}/serviceAttachments/{service_attachment_name}
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Clouddms\V1\ClouddmsResources::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. A service attachment that exposes a database, and has the
     * following format:
     * projects/{project}/regions/{region}/serviceAttachments/{service_attachment_name}
     *
     * Generated from protobuf field <code>string service_attachment = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getServiceAttachment()
    {
        return $this->service_attachment;
    }

    /**
     * Required. A service attachment that exposes a database, and has the
     * following format:
     * projects/{project}/regions/{region}/serviceAttachments/{service_attachment_name}
     *
     * Generated from protobuf field <code>string service_attachment = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setServiceAttachment($var)
    {
        GPBUtil::checkString($var, True);
        $this->service_attachment = $var;

        return $this;
    }

}

