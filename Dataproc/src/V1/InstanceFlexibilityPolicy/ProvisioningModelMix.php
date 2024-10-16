<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataproc/v1/clusters.proto

namespace Google\Cloud\Dataproc\V1\InstanceFlexibilityPolicy;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Defines how Dataproc should create VMs with a mixture of provisioning
 * models.
 *
 * Generated from protobuf message <code>google.cloud.dataproc.v1.InstanceFlexibilityPolicy.ProvisioningModelMix</code>
 */
class ProvisioningModelMix extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The base capacity that will always use Standard VMs to avoid
     * risk of more preemption than the minimum capacity you need. Dataproc will
     * create only standard VMs until it reaches standard_capacity_base, then it
     * will start using standard_capacity_percent_above_base to mix Spot with
     * Standard VMs. eg. If 15 instances are requested and
     * standard_capacity_base is 5, Dataproc will create 5 standard VMs and then
     * start mixing spot and standard VMs for remaining 10 instances.
     *
     * Generated from protobuf field <code>optional int32 standard_capacity_base = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $standard_capacity_base = null;
    /**
     * Optional. The percentage of target capacity that should use Standard VM.
     * The remaining percentage will use Spot VMs. The percentage applies only
     * to the capacity above standard_capacity_base. eg. If 15 instances are
     * requested and standard_capacity_base is 5 and
     * standard_capacity_percent_above_base is 30, Dataproc will create 5
     * standard VMs and then start mixing spot and standard VMs for remaining 10
     * instances. The mix will be 30% standard and 70% spot.
     *
     * Generated from protobuf field <code>optional int32 standard_capacity_percent_above_base = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $standard_capacity_percent_above_base = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $standard_capacity_base
     *           Optional. The base capacity that will always use Standard VMs to avoid
     *           risk of more preemption than the minimum capacity you need. Dataproc will
     *           create only standard VMs until it reaches standard_capacity_base, then it
     *           will start using standard_capacity_percent_above_base to mix Spot with
     *           Standard VMs. eg. If 15 instances are requested and
     *           standard_capacity_base is 5, Dataproc will create 5 standard VMs and then
     *           start mixing spot and standard VMs for remaining 10 instances.
     *     @type int $standard_capacity_percent_above_base
     *           Optional. The percentage of target capacity that should use Standard VM.
     *           The remaining percentage will use Spot VMs. The percentage applies only
     *           to the capacity above standard_capacity_base. eg. If 15 instances are
     *           requested and standard_capacity_base is 5 and
     *           standard_capacity_percent_above_base is 30, Dataproc will create 5
     *           standard VMs and then start mixing spot and standard VMs for remaining 10
     *           instances. The mix will be 30% standard and 70% spot.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataproc\V1\Clusters::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The base capacity that will always use Standard VMs to avoid
     * risk of more preemption than the minimum capacity you need. Dataproc will
     * create only standard VMs until it reaches standard_capacity_base, then it
     * will start using standard_capacity_percent_above_base to mix Spot with
     * Standard VMs. eg. If 15 instances are requested and
     * standard_capacity_base is 5, Dataproc will create 5 standard VMs and then
     * start mixing spot and standard VMs for remaining 10 instances.
     *
     * Generated from protobuf field <code>optional int32 standard_capacity_base = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getStandardCapacityBase()
    {
        return isset($this->standard_capacity_base) ? $this->standard_capacity_base : 0;
    }

    public function hasStandardCapacityBase()
    {
        return isset($this->standard_capacity_base);
    }

    public function clearStandardCapacityBase()
    {
        unset($this->standard_capacity_base);
    }

    /**
     * Optional. The base capacity that will always use Standard VMs to avoid
     * risk of more preemption than the minimum capacity you need. Dataproc will
     * create only standard VMs until it reaches standard_capacity_base, then it
     * will start using standard_capacity_percent_above_base to mix Spot with
     * Standard VMs. eg. If 15 instances are requested and
     * standard_capacity_base is 5, Dataproc will create 5 standard VMs and then
     * start mixing spot and standard VMs for remaining 10 instances.
     *
     * Generated from protobuf field <code>optional int32 standard_capacity_base = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setStandardCapacityBase($var)
    {
        GPBUtil::checkInt32($var);
        $this->standard_capacity_base = $var;

        return $this;
    }

    /**
     * Optional. The percentage of target capacity that should use Standard VM.
     * The remaining percentage will use Spot VMs. The percentage applies only
     * to the capacity above standard_capacity_base. eg. If 15 instances are
     * requested and standard_capacity_base is 5 and
     * standard_capacity_percent_above_base is 30, Dataproc will create 5
     * standard VMs and then start mixing spot and standard VMs for remaining 10
     * instances. The mix will be 30% standard and 70% spot.
     *
     * Generated from protobuf field <code>optional int32 standard_capacity_percent_above_base = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getStandardCapacityPercentAboveBase()
    {
        return isset($this->standard_capacity_percent_above_base) ? $this->standard_capacity_percent_above_base : 0;
    }

    public function hasStandardCapacityPercentAboveBase()
    {
        return isset($this->standard_capacity_percent_above_base);
    }

    public function clearStandardCapacityPercentAboveBase()
    {
        unset($this->standard_capacity_percent_above_base);
    }

    /**
     * Optional. The percentage of target capacity that should use Standard VM.
     * The remaining percentage will use Spot VMs. The percentage applies only
     * to the capacity above standard_capacity_base. eg. If 15 instances are
     * requested and standard_capacity_base is 5 and
     * standard_capacity_percent_above_base is 30, Dataproc will create 5
     * standard VMs and then start mixing spot and standard VMs for remaining 10
     * instances. The mix will be 30% standard and 70% spot.
     *
     * Generated from protobuf field <code>optional int32 standard_capacity_percent_above_base = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setStandardCapacityPercentAboveBase($var)
    {
        GPBUtil::checkInt32($var);
        $this->standard_capacity_percent_above_base = $var;

        return $this;
    }

}


