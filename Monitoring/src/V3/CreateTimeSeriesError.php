<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/metric_service.proto

namespace Google\Cloud\Monitoring\V3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * DEPRECATED. Used to hold per-time-series error status.
 *
 * Generated from protobuf message <code>google.monitoring.v3.CreateTimeSeriesError</code>
 */
class CreateTimeSeriesError extends \Google\Protobuf\Internal\Message
{
    /**
     * DEPRECATED. Time series ID that resulted in the `status` error.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.TimeSeries time_series = 1 [deprecated = true];</code>
     * @deprecated
     */
    protected $time_series = null;
    /**
     * DEPRECATED. The status of the requested write operation for `time_series`.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 2 [deprecated = true];</code>
     * @deprecated
     */
    protected $status = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Monitoring\V3\TimeSeries $time_series
     *           DEPRECATED. Time series ID that resulted in the `status` error.
     *     @type \Google\Rpc\Status $status
     *           DEPRECATED. The status of the requested write operation for `time_series`.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Monitoring\V3\MetricService::initOnce();
        parent::__construct($data);
    }

    /**
     * DEPRECATED. Time series ID that resulted in the `status` error.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.TimeSeries time_series = 1 [deprecated = true];</code>
     * @return \Google\Cloud\Monitoring\V3\TimeSeries|null
     * @deprecated
     */
    public function getTimeSeries()
    {
        if (isset($this->time_series)) {
            @trigger_error('time_series is deprecated.', E_USER_DEPRECATED);
        }
        return $this->time_series;
    }

    public function hasTimeSeries()
    {
        if (isset($this->time_series)) {
            @trigger_error('time_series is deprecated.', E_USER_DEPRECATED);
        }
        return isset($this->time_series);
    }

    public function clearTimeSeries()
    {
        @trigger_error('time_series is deprecated.', E_USER_DEPRECATED);
        unset($this->time_series);
    }

    /**
     * DEPRECATED. Time series ID that resulted in the `status` error.
     *
     * Generated from protobuf field <code>.google.monitoring.v3.TimeSeries time_series = 1 [deprecated = true];</code>
     * @param \Google\Cloud\Monitoring\V3\TimeSeries $var
     * @return $this
     * @deprecated
     */
    public function setTimeSeries($var)
    {
        @trigger_error('time_series is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkMessage($var, \Google\Cloud\Monitoring\V3\TimeSeries::class);
        $this->time_series = $var;

        return $this;
    }

    /**
     * DEPRECATED. The status of the requested write operation for `time_series`.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 2 [deprecated = true];</code>
     * @return \Google\Rpc\Status|null
     * @deprecated
     */
    public function getStatus()
    {
        if (isset($this->status)) {
            @trigger_error('status is deprecated.', E_USER_DEPRECATED);
        }
        return $this->status;
    }

    public function hasStatus()
    {
        if (isset($this->status)) {
            @trigger_error('status is deprecated.', E_USER_DEPRECATED);
        }
        return isset($this->status);
    }

    public function clearStatus()
    {
        @trigger_error('status is deprecated.', E_USER_DEPRECATED);
        unset($this->status);
    }

    /**
     * DEPRECATED. The status of the requested write operation for `time_series`.
     *
     * Generated from protobuf field <code>.google.rpc.Status status = 2 [deprecated = true];</code>
     * @param \Google\Rpc\Status $var
     * @return $this
     * @deprecated
     */
    public function setStatus($var)
    {
        @trigger_error('status is deprecated.', E_USER_DEPRECATED);
        GPBUtil::checkMessage($var, \Google\Rpc\Status::class);
        $this->status = $var;

        return $this;
    }

}

