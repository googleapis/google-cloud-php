<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/compute/v1/compute.proto

namespace Google\Cloud\Compute\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Custom Metrics are used for WEIGHTED_ROUND_ROBIN locality_lb_policy.
 *
 * Generated from protobuf message <code>google.cloud.compute.v1.BackendServiceCustomMetric</code>
 */
class BackendServiceCustomMetric extends \Google\Protobuf\Internal\Message
{
    /**
     * If true, the metric data is not used for load balancing.
     *
     * Generated from protobuf field <code>optional bool dry_run = 323854839;</code>
     */
    private $dry_run = null;
    /**
     * Name of a custom utilization signal. The name must be 1-64 characters long and match the regular expression [a-z]([-_.a-z0-9]*[a-z0-9])? which means the first character must be a lowercase letter, and all following characters must be a dash, period, underscore, lowercase letter, or digit, except the last character, which cannot be a dash, period, or underscore. For usage guidelines, see Custom Metrics balancing mode. This field can only be used for a global or regional backend service with the loadBalancingScheme set to EXTERNAL_MANAGED, INTERNAL_MANAGED INTERNAL_SELF_MANAGED.
     *
     * Generated from protobuf field <code>optional string name = 3373707;</code>
     */
    private $name = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $dry_run
     *           If true, the metric data is not used for load balancing.
     *     @type string $name
     *           Name of a custom utilization signal. The name must be 1-64 characters long and match the regular expression [a-z]([-_.a-z0-9]*[a-z0-9])? which means the first character must be a lowercase letter, and all following characters must be a dash, period, underscore, lowercase letter, or digit, except the last character, which cannot be a dash, period, or underscore. For usage guidelines, see Custom Metrics balancing mode. This field can only be used for a global or regional backend service with the loadBalancingScheme set to EXTERNAL_MANAGED, INTERNAL_MANAGED INTERNAL_SELF_MANAGED.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Compute\V1\Compute::initOnce();
        parent::__construct($data);
    }

    /**
     * If true, the metric data is not used for load balancing.
     *
     * Generated from protobuf field <code>optional bool dry_run = 323854839;</code>
     * @return bool
     */
    public function getDryRun()
    {
        return isset($this->dry_run) ? $this->dry_run : false;
    }

    public function hasDryRun()
    {
        return isset($this->dry_run);
    }

    public function clearDryRun()
    {
        unset($this->dry_run);
    }

    /**
     * If true, the metric data is not used for load balancing.
     *
     * Generated from protobuf field <code>optional bool dry_run = 323854839;</code>
     * @param bool $var
     * @return $this
     */
    public function setDryRun($var)
    {
        GPBUtil::checkBool($var);
        $this->dry_run = $var;

        return $this;
    }

    /**
     * Name of a custom utilization signal. The name must be 1-64 characters long and match the regular expression [a-z]([-_.a-z0-9]*[a-z0-9])? which means the first character must be a lowercase letter, and all following characters must be a dash, period, underscore, lowercase letter, or digit, except the last character, which cannot be a dash, period, or underscore. For usage guidelines, see Custom Metrics balancing mode. This field can only be used for a global or regional backend service with the loadBalancingScheme set to EXTERNAL_MANAGED, INTERNAL_MANAGED INTERNAL_SELF_MANAGED.
     *
     * Generated from protobuf field <code>optional string name = 3373707;</code>
     * @return string
     */
    public function getName()
    {
        return isset($this->name) ? $this->name : '';
    }

    public function hasName()
    {
        return isset($this->name);
    }

    public function clearName()
    {
        unset($this->name);
    }

    /**
     * Name of a custom utilization signal. The name must be 1-64 characters long and match the regular expression [a-z]([-_.a-z0-9]*[a-z0-9])? which means the first character must be a lowercase letter, and all following characters must be a dash, period, underscore, lowercase letter, or digit, except the last character, which cannot be a dash, period, or underscore. For usage guidelines, see Custom Metrics balancing mode. This field can only be used for a global or regional backend service with the loadBalancingScheme set to EXTERNAL_MANAGED, INTERNAL_MANAGED INTERNAL_SELF_MANAGED.
     *
     * Generated from protobuf field <code>optional string name = 3373707;</code>
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

