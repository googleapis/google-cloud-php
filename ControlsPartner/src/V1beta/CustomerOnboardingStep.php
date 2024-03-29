<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/cloudcontrolspartner/v1beta/customers.proto

namespace Google\Cloud\CloudControlsPartner\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Container for customer onboarding information
 *
 * Generated from protobuf message <code>google.cloud.cloudcontrolspartner.v1beta.CustomerOnboardingStep</code>
 */
class CustomerOnboardingStep extends \Google\Protobuf\Internal\Message
{
    /**
     * The onboarding step
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.CustomerOnboardingStep.Step step = 1;</code>
     */
    protected $step = 0;
    /**
     * The starting time of the onboarding step
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 2;</code>
     */
    protected $start_time = null;
    /**
     * The completion time of the onboarding step
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp completion_time = 3;</code>
     */
    protected $completion_time = null;
    /**
     * Output only. Current state of the step
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.CompletionState completion_state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $completion_state = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $step
     *           The onboarding step
     *     @type \Google\Protobuf\Timestamp $start_time
     *           The starting time of the onboarding step
     *     @type \Google\Protobuf\Timestamp $completion_time
     *           The completion time of the onboarding step
     *     @type int $completion_state
     *           Output only. Current state of the step
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Cloudcontrolspartner\V1Beta\Customers::initOnce();
        parent::__construct($data);
    }

    /**
     * The onboarding step
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.CustomerOnboardingStep.Step step = 1;</code>
     * @return int
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * The onboarding step
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.CustomerOnboardingStep.Step step = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setStep($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\CloudControlsPartner\V1beta\CustomerOnboardingStep\Step::class);
        $this->step = $var;

        return $this;
    }

    /**
     * The starting time of the onboarding step
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 2;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getStartTime()
    {
        return $this->start_time;
    }

    public function hasStartTime()
    {
        return isset($this->start_time);
    }

    public function clearStartTime()
    {
        unset($this->start_time);
    }

    /**
     * The starting time of the onboarding step
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp start_time = 2;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setStartTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->start_time = $var;

        return $this;
    }

    /**
     * The completion time of the onboarding step
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp completion_time = 3;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCompletionTime()
    {
        return $this->completion_time;
    }

    public function hasCompletionTime()
    {
        return isset($this->completion_time);
    }

    public function clearCompletionTime()
    {
        unset($this->completion_time);
    }

    /**
     * The completion time of the onboarding step
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp completion_time = 3;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCompletionTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->completion_time = $var;

        return $this;
    }

    /**
     * Output only. Current state of the step
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.CompletionState completion_state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getCompletionState()
    {
        return $this->completion_state;
    }

    /**
     * Output only. Current state of the step
     *
     * Generated from protobuf field <code>.google.cloud.cloudcontrolspartner.v1beta.CompletionState completion_state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setCompletionState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\CloudControlsPartner\V1beta\CompletionState::class);
        $this->completion_state = $var;

        return $this;
    }

}

