<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/apphub/v1/workload.proto

namespace Google\Cloud\AppHub\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Reference of an underlying compute resource represented by the Workload.
 *
 * Generated from protobuf message <code>google.cloud.apphub.v1.WorkloadReference</code>
 */
class WorkloadReference extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. The underlying compute resource uri.
     *
     * Generated from protobuf field <code>string uri = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $uri = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $uri
     *           Output only. The underlying compute resource uri.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Apphub\V1\Workload::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. The underlying compute resource uri.
     *
     * Generated from protobuf field <code>string uri = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Output only. The underlying compute resource uri.
     *
     * Generated from protobuf field <code>string uri = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param string $var
     * @return $this
     */
    public function setUri($var)
    {
        GPBUtil::checkString($var, True);
        $this->uri = $var;

        return $this;
    }

}

