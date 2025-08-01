<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/networkservices/v1/service_lb_policy.proto

namespace Google\Cloud\NetworkServices\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * ServiceLbPolicy holds global load balancing and traffic distribution
 * configuration that can be applied to a BackendService.
 *
 * Generated from protobuf message <code>google.cloud.networkservices.v1.ServiceLbPolicy</code>
 */
class ServiceLbPolicy extends \Google\Protobuf\Internal\Message
{
    /**
     * Identifier. Name of the ServiceLbPolicy resource. It matches pattern
     * `projects/{project}/locations/{location}/serviceLbPolicies/{service_lb_policy_name}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Output only. The timestamp when this resource was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. The timestamp when this resource was last updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;
    /**
     * Optional. Set of label tags associated with the ServiceLbPolicy resource.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $labels;
    /**
     * Optional. A free-text description of the resource. Max length 1024
     * characters.
     *
     * Generated from protobuf field <code>string description = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $description = '';
    /**
     * Optional. The type of load balancing algorithm to be used. The default
     * behavior is WATERFALL_BY_REGION.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.LoadBalancingAlgorithm load_balancing_algorithm = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $load_balancing_algorithm = 0;
    /**
     * Optional. Configuration to automatically move traffic away for unhealthy
     * IG/NEG for the associated Backend Service.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.AutoCapacityDrain auto_capacity_drain = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $auto_capacity_drain = null;
    /**
     * Optional. Configuration related to health based failover.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.FailoverConfig failover_config = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $failover_config = null;
    /**
     * Optional. Configuration to provide isolation support for the associated
     * Backend Service.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.IsolationConfig isolation_config = 11 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $isolation_config = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Identifier. Name of the ServiceLbPolicy resource. It matches pattern
     *           `projects/{project}/locations/{location}/serviceLbPolicies/{service_lb_policy_name}`.
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. The timestamp when this resource was created.
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. The timestamp when this resource was last updated.
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Optional. Set of label tags associated with the ServiceLbPolicy resource.
     *     @type string $description
     *           Optional. A free-text description of the resource. Max length 1024
     *           characters.
     *     @type int $load_balancing_algorithm
     *           Optional. The type of load balancing algorithm to be used. The default
     *           behavior is WATERFALL_BY_REGION.
     *     @type \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\AutoCapacityDrain $auto_capacity_drain
     *           Optional. Configuration to automatically move traffic away for unhealthy
     *           IG/NEG for the associated Backend Service.
     *     @type \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\FailoverConfig $failover_config
     *           Optional. Configuration related to health based failover.
     *     @type \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\IsolationConfig $isolation_config
     *           Optional. Configuration to provide isolation support for the associated
     *           Backend Service.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Networkservices\V1\ServiceLbPolicy::initOnce();
        parent::__construct($data);
    }

    /**
     * Identifier. Name of the ServiceLbPolicy resource. It matches pattern
     * `projects/{project}/locations/{location}/serviceLbPolicies/{service_lb_policy_name}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. Name of the ServiceLbPolicy resource. It matches pattern
     * `projects/{project}/locations/{location}/serviceLbPolicies/{service_lb_policy_name}`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * Output only. The timestamp when this resource was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function hasCreateTime()
    {
        return isset($this->create_time);
    }

    public function clearCreateTime()
    {
        unset($this->create_time);
    }

    /**
     * Output only. The timestamp when this resource was created.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->create_time = $var;

        return $this;
    }

    /**
     * Output only. The timestamp when this resource was last updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    public function hasUpdateTime()
    {
        return isset($this->update_time);
    }

    public function clearUpdateTime()
    {
        unset($this->update_time);
    }

    /**
     * Output only. The timestamp when this resource was last updated.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUpdateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->update_time = $var;

        return $this;
    }

    /**
     * Optional. Set of label tags associated with the ServiceLbPolicy resource.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Optional. Set of label tags associated with the ServiceLbPolicy resource.
     *
     * Generated from protobuf field <code>map<string, string> labels = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

    /**
     * Optional. A free-text description of the resource. Max length 1024
     * characters.
     *
     * Generated from protobuf field <code>string description = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Optional. A free-text description of the resource. Max length 1024
     * characters.
     *
     * Generated from protobuf field <code>string description = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * Optional. The type of load balancing algorithm to be used. The default
     * behavior is WATERFALL_BY_REGION.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.LoadBalancingAlgorithm load_balancing_algorithm = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getLoadBalancingAlgorithm()
    {
        return $this->load_balancing_algorithm;
    }

    /**
     * Optional. The type of load balancing algorithm to be used. The default
     * behavior is WATERFALL_BY_REGION.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.LoadBalancingAlgorithm load_balancing_algorithm = 6 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setLoadBalancingAlgorithm($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\LoadBalancingAlgorithm::class);
        $this->load_balancing_algorithm = $var;

        return $this;
    }

    /**
     * Optional. Configuration to automatically move traffic away for unhealthy
     * IG/NEG for the associated Backend Service.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.AutoCapacityDrain auto_capacity_drain = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\AutoCapacityDrain|null
     */
    public function getAutoCapacityDrain()
    {
        return $this->auto_capacity_drain;
    }

    public function hasAutoCapacityDrain()
    {
        return isset($this->auto_capacity_drain);
    }

    public function clearAutoCapacityDrain()
    {
        unset($this->auto_capacity_drain);
    }

    /**
     * Optional. Configuration to automatically move traffic away for unhealthy
     * IG/NEG for the associated Backend Service.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.AutoCapacityDrain auto_capacity_drain = 8 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\AutoCapacityDrain $var
     * @return $this
     */
    public function setAutoCapacityDrain($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\AutoCapacityDrain::class);
        $this->auto_capacity_drain = $var;

        return $this;
    }

    /**
     * Optional. Configuration related to health based failover.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.FailoverConfig failover_config = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\FailoverConfig|null
     */
    public function getFailoverConfig()
    {
        return $this->failover_config;
    }

    public function hasFailoverConfig()
    {
        return isset($this->failover_config);
    }

    public function clearFailoverConfig()
    {
        unset($this->failover_config);
    }

    /**
     * Optional. Configuration related to health based failover.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.FailoverConfig failover_config = 10 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\FailoverConfig $var
     * @return $this
     */
    public function setFailoverConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\FailoverConfig::class);
        $this->failover_config = $var;

        return $this;
    }

    /**
     * Optional. Configuration to provide isolation support for the associated
     * Backend Service.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.IsolationConfig isolation_config = 11 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\IsolationConfig|null
     */
    public function getIsolationConfig()
    {
        return $this->isolation_config;
    }

    public function hasIsolationConfig()
    {
        return isset($this->isolation_config);
    }

    public function clearIsolationConfig()
    {
        unset($this->isolation_config);
    }

    /**
     * Optional. Configuration to provide isolation support for the associated
     * Backend Service.
     *
     * Generated from protobuf field <code>.google.cloud.networkservices.v1.ServiceLbPolicy.IsolationConfig isolation_config = 11 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\IsolationConfig $var
     * @return $this
     */
    public function setIsolationConfig($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\NetworkServices\V1\ServiceLbPolicy\IsolationConfig::class);
        $this->isolation_config = $var;

        return $this;
    }

}

