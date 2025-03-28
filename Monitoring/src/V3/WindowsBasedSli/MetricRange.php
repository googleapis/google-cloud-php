<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/service.proto

namespace Google\Cloud\Monitoring\V3\WindowsBasedSli;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A `MetricRange` is used when each window is good when the value x of a
 * single `TimeSeries` satisfies `range.min <= x <= range.max`. The provided
 * `TimeSeries` must have `ValueType = INT64` or `ValueType = DOUBLE` and
 * `MetricKind = GAUGE`.
 *
 * Generated from protobuf message <code>google.monitoring.v3.WindowsBasedSli.MetricRange</code>
 */
class MetricRange extends \Google\Protobuf\Internal\Message
{
    /**
     * A [monitoring filter](https://cloud.google.com/monitoring/api/v3/filters)
     * specifying the `TimeSeries` to use for evaluating window quality.
     *
     * Generated from protobuf field <code>string time_series = 1;</code>
     */
    protected $time_series = '';
    /**
     * Range of values considered "good." For a one-sided range, set one bound
     * to an infinite value.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.Range range = 4;</code>
     */
    protected $range = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $time_series
     *           A [monitoring filter](https://cloud.google.com/monitoring/api/v3/filters)
     *           specifying the `TimeSeries` to use for evaluating window quality.
     *     @type \Google\Cloud\Monitoring\V3\Range $range
     *           Range of values considered "good." For a one-sided range, set one bound
     *           to an infinite value.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Monitoring\V3\Service::initOnce();
        parent::__construct($data);
    }

    /**
     * A [monitoring filter](https://cloud.google.com/monitoring/api/v3/filters)
     * specifying the `TimeSeries` to use for evaluating window quality.
     *
     * Generated from protobuf field <code>string time_series = 1;</code>
     * @return string
     */
    public function getTimeSeries()
    {
        return $this->time_series;
    }

    /**
     * A [monitoring filter](https://cloud.google.com/monitoring/api/v3/filters)
     * specifying the `TimeSeries` to use for evaluating window quality.
     *
     * Generated from protobuf field <code>string time_series = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTimeSeries($var)
    {
        GPBUtil::checkString($var, True);
        $this->time_series = $var;

        return $this;
    }

    /**
     * Range of values considered "good." For a one-sided range, set one bound
     * to an infinite value.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.Range range = 4;</code>
     * @return \Google\Cloud\Monitoring\V3\Range|null
     */
    public function getRange()
    {
        return $this->range;
    }

    public function hasRange()
    {
        return isset($this->range);
    }

    public function clearRange()
    {
        unset($this->range);
    }

    /**
     * Range of values considered "good." For a one-sided range, set one bound
     * to an infinite value.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.Range range = 4;</code>
     * @param \Google\Cloud\Monitoring\V3\Range $var
     * @return $this
     */
    public function setRange($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Monitoring\V3\Range::class);
        $this->range = $var;

        return $this;
    }

}


