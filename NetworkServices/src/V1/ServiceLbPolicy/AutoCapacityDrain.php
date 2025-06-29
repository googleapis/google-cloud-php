<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkservices/v1/service_lb_policy.proto

namespace Google\Cloud\NetworkServices\V1\ServiceLbPolicy;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Option to specify if an unhealthy IG/NEG should be considered for global
 * load balancing and traffic routing.
 *
 * Generated from protobuf message <code>google.cloud.networkservices.v1.ServiceLbPolicy.AutoCapacityDrain</code>
 */
class AutoCapacityDrain extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. If set to 'True', an unhealthy IG/NEG will be set as drained.
     * - An IG/NEG is considered unhealthy if less than 25% of the
     * instances/endpoints in the IG/NEG are healthy.
     * - This option will never result in draining more than 50% of the
     * configured IGs/NEGs for the Backend Service.
     *
     * Generated from protobuf field <code>bool enable = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $enable = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $enable
     *           Optional. If set to 'True', an unhealthy IG/NEG will be set as drained.
     *           - An IG/NEG is considered unhealthy if less than 25% of the
     *           instances/endpoints in the IG/NEG are healthy.
     *           - This option will never result in draining more than 50% of the
     *           configured IGs/NEGs for the Backend Service.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkservices\V1\ServiceLbPolicy::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. If set to 'True', an unhealthy IG/NEG will be set as drained.
     * - An IG/NEG is considered unhealthy if less than 25% of the
     * instances/endpoints in the IG/NEG are healthy.
     * - This option will never result in draining more than 50% of the
     * configured IGs/NEGs for the Backend Service.
     *
     * Generated from protobuf field <code>bool enable = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getEnable()
    {
        return $this->enable;
    }

    /**
     * Optional. If set to 'True', an unhealthy IG/NEG will be set as drained.
     * - An IG/NEG is considered unhealthy if less than 25% of the
     * instances/endpoints in the IG/NEG are healthy.
     * - This option will never result in draining more than 50% of the
     * configured IGs/NEGs for the Backend Service.
     *
     * Generated from protobuf field <code>bool enable = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setEnable($var)
    {
        GPBUtil::checkBool($var);
        $this->enable = $var;

        return $this;
    }

}


