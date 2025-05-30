<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/container/v1/cluster_service.proto

namespace Google\Cloud\Container\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * PodAutoscaling is used for configuration of parameters
 * for workload autoscaling.
 *
 * Generated from protobuf message <code>google.container.v1.PodAutoscaling</code>
 */
class PodAutoscaling extends \Google\Protobuf\Internal\Message
{
    /**
     * Selected Horizontal Pod Autoscaling profile.
     *
     * Generated from protobuf field <code>optional .google.container.v1.PodAutoscaling.HPAProfile hpa_profile = 2;</code>
     */
    protected $hpa_profile = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $hpa_profile
     *           Selected Horizontal Pod Autoscaling profile.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Container\V1\ClusterService::initOnce();
        parent::__construct($data);
    }

    /**
     * Selected Horizontal Pod Autoscaling profile.
     *
     * Generated from protobuf field <code>optional .google.container.v1.PodAutoscaling.HPAProfile hpa_profile = 2;</code>
     * @return int
     */
    public function getHpaProfile()
    {
        return isset($this->hpa_profile) ? $this->hpa_profile : 0;
    }

    public function hasHpaProfile()
    {
        return isset($this->hpa_profile);
    }

    public function clearHpaProfile()
    {
        unset($this->hpa_profile);
    }

    /**
     * Selected Horizontal Pod Autoscaling profile.
     *
     * Generated from protobuf field <code>optional .google.container.v1.PodAutoscaling.HPAProfile hpa_profile = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setHpaProfile($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Container\V1\PodAutoscaling\HPAProfile::class);
        $this->hpa_profile = $var;

        return $this;
    }

}

