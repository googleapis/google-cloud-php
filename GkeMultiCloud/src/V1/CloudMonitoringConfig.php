<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/gkemulticloud/v1/common_resources.proto

namespace Google\Cloud\GkeMultiCloud\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * CloudMonitoringConfig defines the configuration for
 * built-in Cloud Logging and Monitoring.
 * Only for Attached Clusters.
 *
 * Generated from protobuf message <code>google.cloud.gkemulticloud.v1.CloudMonitoringConfig</code>
 */
class CloudMonitoringConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Enable GKE-native logging and metrics.
     * Only for Attached Clusters.
     *
     * Generated from protobuf field <code>optional bool enabled = 1;</code>
     */
    protected $enabled = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $enabled
     *           Enable GKE-native logging and metrics.
     *           Only for Attached Clusters.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Gkemulticloud\V1\CommonResources::initOnce();
        parent::__construct($data);
    }

    /**
     * Enable GKE-native logging and metrics.
     * Only for Attached Clusters.
     *
     * Generated from protobuf field <code>optional bool enabled = 1;</code>
     * @return bool
     */
    public function getEnabled()
    {
        return isset($this->enabled) ? $this->enabled : false;
    }

    public function hasEnabled()
    {
        return isset($this->enabled);
    }

    public function clearEnabled()
    {
        unset($this->enabled);
    }

    /**
     * Enable GKE-native logging and metrics.
     * Only for Attached Clusters.
     *
     * Generated from protobuf field <code>optional bool enabled = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setEnabled($var)
    {
        GPBUtil::checkBool($var);
        $this->enabled = $var;

        return $this;
    }

}

