<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/securitycenter/v2/attack_exposure.proto

namespace Google\Cloud\SecurityCenter\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An attack exposure contains the results of an attack path simulation run.
 *
 * Generated from protobuf message <code>google.cloud.securitycenter.v2.AttackExposure</code>
 */
class AttackExposure extends \Google\Protobuf\Internal\Message
{
    /**
     * A number between 0 (inclusive) and infinity that represents how important
     * this finding is to remediate. The higher the score, the more important it
     * is to remediate.
     *
     * Generated from protobuf field <code>double score = 1;</code>
     */
    protected $score = 0.0;
    /**
     * The most recent time the attack exposure was updated on this finding.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp latest_calculation_time = 2;</code>
     */
    protected $latest_calculation_time = null;
    /**
     * The resource name of the attack path simulation result that contains the
     * details regarding this attack exposure score.
     * Example: `organizations/123/simulations/456/attackExposureResults/789`
     *
     * Generated from protobuf field <code>string attack_exposure_result = 3;</code>
     */
    protected $attack_exposure_result = '';
    /**
     * Output only. What state this AttackExposure is in. This captures whether or
     * not an attack exposure has been calculated or not.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.AttackExposure.State state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $state = 0;
    /**
     * The number of high value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_high_value_resources_count = 5;</code>
     */
    protected $exposed_high_value_resources_count = 0;
    /**
     * The number of medium value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_medium_value_resources_count = 6;</code>
     */
    protected $exposed_medium_value_resources_count = 0;
    /**
     * The number of high value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_low_value_resources_count = 7;</code>
     */
    protected $exposed_low_value_resources_count = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type float $score
     *           A number between 0 (inclusive) and infinity that represents how important
     *           this finding is to remediate. The higher the score, the more important it
     *           is to remediate.
     *     @type \Google\Protobuf\Timestamp $latest_calculation_time
     *           The most recent time the attack exposure was updated on this finding.
     *     @type string $attack_exposure_result
     *           The resource name of the attack path simulation result that contains the
     *           details regarding this attack exposure score.
     *           Example: `organizations/123/simulations/456/attackExposureResults/789`
     *     @type int $state
     *           Output only. What state this AttackExposure is in. This captures whether or
     *           not an attack exposure has been calculated or not.
     *     @type int $exposed_high_value_resources_count
     *           The number of high value resources that are exposed as a result of this
     *           finding.
     *     @type int $exposed_medium_value_resources_count
     *           The number of medium value resources that are exposed as a result of this
     *           finding.
     *     @type int $exposed_low_value_resources_count
     *           The number of high value resources that are exposed as a result of this
     *           finding.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Securitycenter\V2\AttackExposure::initOnce();
        parent::__construct($data);
    }

    /**
     * A number between 0 (inclusive) and infinity that represents how important
     * this finding is to remediate. The higher the score, the more important it
     * is to remediate.
     *
     * Generated from protobuf field <code>double score = 1;</code>
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * A number between 0 (inclusive) and infinity that represents how important
     * this finding is to remediate. The higher the score, the more important it
     * is to remediate.
     *
     * Generated from protobuf field <code>double score = 1;</code>
     * @param float $var
     * @return $this
     */
    public function setScore($var)
    {
        GPBUtil::checkDouble($var);
        $this->score = $var;

        return $this;
    }

    /**
     * The most recent time the attack exposure was updated on this finding.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp latest_calculation_time = 2;</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getLatestCalculationTime()
    {
        return $this->latest_calculation_time;
    }

    public function hasLatestCalculationTime()
    {
        return isset($this->latest_calculation_time);
    }

    public function clearLatestCalculationTime()
    {
        unset($this->latest_calculation_time);
    }

    /**
     * The most recent time the attack exposure was updated on this finding.
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp latest_calculation_time = 2;</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setLatestCalculationTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->latest_calculation_time = $var;

        return $this;
    }

    /**
     * The resource name of the attack path simulation result that contains the
     * details regarding this attack exposure score.
     * Example: `organizations/123/simulations/456/attackExposureResults/789`
     *
     * Generated from protobuf field <code>string attack_exposure_result = 3;</code>
     * @return string
     */
    public function getAttackExposureResult()
    {
        return $this->attack_exposure_result;
    }

    /**
     * The resource name of the attack path simulation result that contains the
     * details regarding this attack exposure score.
     * Example: `organizations/123/simulations/456/attackExposureResults/789`
     *
     * Generated from protobuf field <code>string attack_exposure_result = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setAttackExposureResult($var)
    {
        GPBUtil::checkString($var, True);
        $this->attack_exposure_result = $var;

        return $this;
    }

    /**
     * Output only. What state this AttackExposure is in. This captures whether or
     * not an attack exposure has been calculated or not.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.AttackExposure.State state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Output only. What state this AttackExposure is in. This captures whether or
     * not an attack exposure has been calculated or not.
     *
     * Generated from protobuf field <code>.google.cloud.securitycenter.v2.AttackExposure.State state = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setState($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\SecurityCenter\V2\AttackExposure\State::class);
        $this->state = $var;

        return $this;
    }

    /**
     * The number of high value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_high_value_resources_count = 5;</code>
     * @return int
     */
    public function getExposedHighValueResourcesCount()
    {
        return $this->exposed_high_value_resources_count;
    }

    /**
     * The number of high value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_high_value_resources_count = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setExposedHighValueResourcesCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->exposed_high_value_resources_count = $var;

        return $this;
    }

    /**
     * The number of medium value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_medium_value_resources_count = 6;</code>
     * @return int
     */
    public function getExposedMediumValueResourcesCount()
    {
        return $this->exposed_medium_value_resources_count;
    }

    /**
     * The number of medium value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_medium_value_resources_count = 6;</code>
     * @param int $var
     * @return $this
     */
    public function setExposedMediumValueResourcesCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->exposed_medium_value_resources_count = $var;

        return $this;
    }

    /**
     * The number of high value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_low_value_resources_count = 7;</code>
     * @return int
     */
    public function getExposedLowValueResourcesCount()
    {
        return $this->exposed_low_value_resources_count;
    }

    /**
     * The number of high value resources that are exposed as a result of this
     * finding.
     *
     * Generated from protobuf field <code>int32 exposed_low_value_resources_count = 7;</code>
     * @param int $var
     * @return $this
     */
    public function setExposedLowValueResourcesCount($var)
    {
        GPBUtil::checkInt32($var);
        $this->exposed_low_value_resources_count = $var;

        return $this;
    }

}

