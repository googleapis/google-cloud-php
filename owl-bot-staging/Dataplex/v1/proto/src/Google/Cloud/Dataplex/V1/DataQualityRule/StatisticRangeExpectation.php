<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dataplex/v1/data_quality.proto

namespace Google\Cloud\Dataplex\V1\DataQualityRule;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Evaluates whether the column aggregate statistic lies between a specified
 * range.
 *
 * Generated from protobuf message <code>google.cloud.dataplex.v1.DataQualityRule.StatisticRangeExpectation</code>
 */
class StatisticRangeExpectation extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. The aggregate metric to evaluate.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.DataQualityRule.StatisticRangeExpectation.ColumnStatistic statistic = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $statistic = 0;
    /**
     * Optional. The minimum column statistic value allowed for a row to pass
     * this validation.
     * At least one of `min_value` and `max_value` need to be provided.
     *
     * Generated from protobuf field <code>string min_value = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $min_value = '';
    /**
     * Optional. The maximum column statistic value allowed for a row to pass
     * this validation.
     * At least one of `min_value` and `max_value` need to be provided.
     *
     * Generated from protobuf field <code>string max_value = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $max_value = '';
    /**
     * Optional. Whether column statistic needs to be strictly greater than
     * ('>') the minimum, or if equality is allowed.
     * Only relevant if a `min_value` has been defined. Default = false.
     *
     * Generated from protobuf field <code>bool strict_min_enabled = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $strict_min_enabled = false;
    /**
     * Optional. Whether column statistic needs to be strictly lesser than ('<')
     * the maximum, or if equality is allowed.
     * Only relevant if a `max_value` has been defined. Default = false.
     *
     * Generated from protobuf field <code>bool strict_max_enabled = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $strict_max_enabled = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $statistic
     *           Optional. The aggregate metric to evaluate.
     *     @type string $min_value
     *           Optional. The minimum column statistic value allowed for a row to pass
     *           this validation.
     *           At least one of `min_value` and `max_value` need to be provided.
     *     @type string $max_value
     *           Optional. The maximum column statistic value allowed for a row to pass
     *           this validation.
     *           At least one of `min_value` and `max_value` need to be provided.
     *     @type bool $strict_min_enabled
     *           Optional. Whether column statistic needs to be strictly greater than
     *           ('>') the minimum, or if equality is allowed.
     *           Only relevant if a `min_value` has been defined. Default = false.
     *     @type bool $strict_max_enabled
     *           Optional. Whether column statistic needs to be strictly lesser than ('<')
     *           the maximum, or if equality is allowed.
     *           Only relevant if a `max_value` has been defined. Default = false.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dataplex\V1\DataQuality::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. The aggregate metric to evaluate.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.DataQualityRule.StatisticRangeExpectation.ColumnStatistic statistic = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return int
     */
    public function getStatistic()
    {
        return $this->statistic;
    }

    /**
     * Optional. The aggregate metric to evaluate.
     *
     * Generated from protobuf field <code>.google.cloud.dataplex.v1.DataQualityRule.StatisticRangeExpectation.ColumnStatistic statistic = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param int $var
     * @return $this
     */
    public function setStatistic($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\Dataplex\V1\DataQualityRule\StatisticRangeExpectation\ColumnStatistic::class);
        $this->statistic = $var;

        return $this;
    }

    /**
     * Optional. The minimum column statistic value allowed for a row to pass
     * this validation.
     * At least one of `min_value` and `max_value` need to be provided.
     *
     * Generated from protobuf field <code>string min_value = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getMinValue()
    {
        return $this->min_value;
    }

    /**
     * Optional. The minimum column statistic value allowed for a row to pass
     * this validation.
     * At least one of `min_value` and `max_value` need to be provided.
     *
     * Generated from protobuf field <code>string min_value = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setMinValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->min_value = $var;

        return $this;
    }

    /**
     * Optional. The maximum column statistic value allowed for a row to pass
     * this validation.
     * At least one of `min_value` and `max_value` need to be provided.
     *
     * Generated from protobuf field <code>string max_value = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getMaxValue()
    {
        return $this->max_value;
    }

    /**
     * Optional. The maximum column statistic value allowed for a row to pass
     * this validation.
     * At least one of `min_value` and `max_value` need to be provided.
     *
     * Generated from protobuf field <code>string max_value = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setMaxValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->max_value = $var;

        return $this;
    }

    /**
     * Optional. Whether column statistic needs to be strictly greater than
     * ('>') the minimum, or if equality is allowed.
     * Only relevant if a `min_value` has been defined. Default = false.
     *
     * Generated from protobuf field <code>bool strict_min_enabled = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getStrictMinEnabled()
    {
        return $this->strict_min_enabled;
    }

    /**
     * Optional. Whether column statistic needs to be strictly greater than
     * ('>') the minimum, or if equality is allowed.
     * Only relevant if a `min_value` has been defined. Default = false.
     *
     * Generated from protobuf field <code>bool strict_min_enabled = 4 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setStrictMinEnabled($var)
    {
        GPBUtil::checkBool($var);
        $this->strict_min_enabled = $var;

        return $this;
    }

    /**
     * Optional. Whether column statistic needs to be strictly lesser than ('<')
     * the maximum, or if equality is allowed.
     * Only relevant if a `max_value` has been defined. Default = false.
     *
     * Generated from protobuf field <code>bool strict_max_enabled = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getStrictMaxEnabled()
    {
        return $this->strict_max_enabled;
    }

    /**
     * Optional. Whether column statistic needs to be strictly lesser than ('<')
     * the maximum, or if equality is allowed.
     * Only relevant if a `max_value` has been defined. Default = false.
     *
     * Generated from protobuf field <code>bool strict_max_enabled = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setStrictMaxEnabled($var)
    {
        GPBUtil::checkBool($var);
        $this->strict_max_enabled = $var;

        return $this;
    }

}

// Adding a class alias for backwards compatibility with the previous class name.
class_alias(StatisticRangeExpectation::class, \Google\Cloud\Dataplex\V1\DataQualityRule_StatisticRangeExpectation::class);
