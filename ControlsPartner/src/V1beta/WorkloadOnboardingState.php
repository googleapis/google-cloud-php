<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/cloudcontrolspartner/v1beta/customer_workloads.proto

namespace Google\Cloud\CloudControlsPartner\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Container for workload onboarding steps.
 *
 * Generated from protobuf message <code>google.cloud.cloudcontrolspartner.v1beta.WorkloadOnboardingState</code>
 */
class WorkloadOnboardingState extends \Google\Protobuf\Internal\Message
{
    /**
     * List of workload onboarding steps.
     *
     * Generated from protobuf field <code>repeated .google.cloud.cloudcontrolspartner.v1beta.WorkloadOnboardingStep onboarding_steps = 1;</code>
     */
    private $onboarding_steps;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\CloudControlsPartner\V1beta\WorkloadOnboardingStep>|\Google\Protobuf\Internal\RepeatedField $onboarding_steps
     *           List of workload onboarding steps.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Cloudcontrolspartner\V1Beta\CustomerWorkloads::initOnce();
        parent::__construct($data);
    }

    /**
     * List of workload onboarding steps.
     *
     * Generated from protobuf field <code>repeated .google.cloud.cloudcontrolspartner.v1beta.WorkloadOnboardingStep onboarding_steps = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getOnboardingSteps()
    {
        return $this->onboarding_steps;
    }

    /**
     * List of workload onboarding steps.
     *
     * Generated from protobuf field <code>repeated .google.cloud.cloudcontrolspartner.v1beta.WorkloadOnboardingStep onboarding_steps = 1;</code>
     * @param array<\Google\Cloud\CloudControlsPartner\V1beta\WorkloadOnboardingStep>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setOnboardingSteps($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\CloudControlsPartner\V1beta\WorkloadOnboardingStep::class);
        $this->onboarding_steps = $arr;

        return $this;
    }

}

