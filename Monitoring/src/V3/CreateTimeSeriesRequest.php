<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/monitoring/v3/metric_service.proto

namespace Google\Cloud\Monitoring\V3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The `CreateTimeSeries` request.
 *
 * Generated from protobuf message <code>google.monitoring.v3.CreateTimeSeriesRequest</code>
 */
class CreateTimeSeriesRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The
     * [project](https://cloud.google.com/monitoring/api/v3#project_name) on which
     * to execute the request. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Required. The new data to be added to a list of time series.
     * Adds at most one data point to each of several time series.  The new data
     * point must be more recent than any other point in its time series.  Each
     * `TimeSeries` value must fully specify a unique time series by supplying
     * all label values for the metric and the monitored resource.
     * The maximum number of `TimeSeries` objects per `Create` request is 200.
     *
     * Generated from protobuf field <code>repeated .google.monitoring.v3.TimeSeries time_series = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    private $time_series;

    /**
     * @param string                                   $name       Required. The
     *                                                             [project](https://cloud.google.com/monitoring/api/v3#project_name) on which
     *                                                             to execute the request. The format is:
     *
     *                                                             projects/[PROJECT_ID_OR_NUMBER]
     *                                                             Please see {@see MetricServiceClient::projectName()} for help formatting this field.
     * @param \Google\Cloud\Monitoring\V3\TimeSeries[] $timeSeries Required. The new data to be added to a list of time series.
     *                                                             Adds at most one data point to each of several time series.  The new data
     *                                                             point must be more recent than any other point in its time series.  Each
     *                                                             `TimeSeries` value must fully specify a unique time series by supplying
     *                                                             all label values for the metric and the monitored resource.
     *
     *                                                             The maximum number of `TimeSeries` objects per `Create` request is 200.
     *
     * @return \Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest
     *
     * @experimental
     */
    public static function build(string $name, array $timeSeries): self
    {
        return (new self())
            ->setName($name)
            ->setTimeSeries($timeSeries);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The
     *           [project](https://cloud.google.com/monitoring/api/v3#project_name) on which
     *           to execute the request. The format is:
     *               projects/[PROJECT_ID_OR_NUMBER]
     *     @type array<\Google\Cloud\Monitoring\V3\TimeSeries>|\Google\Protobuf\Internal\RepeatedField $time_series
     *           Required. The new data to be added to a list of time series.
     *           Adds at most one data point to each of several time series.  The new data
     *           point must be more recent than any other point in its time series.  Each
     *           `TimeSeries` value must fully specify a unique time series by supplying
     *           all label values for the metric and the monitored resource.
     *           The maximum number of `TimeSeries` objects per `Create` request is 200.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Monitoring\V3\MetricService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The
     * [project](https://cloud.google.com/monitoring/api/v3#project_name) on which
     * to execute the request. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The
     * [project](https://cloud.google.com/monitoring/api/v3#project_name) on which
     * to execute the request. The format is:
     *     projects/[PROJECT_ID_OR_NUMBER]
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
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
     * Required. The new data to be added to a list of time series.
     * Adds at most one data point to each of several time series.  The new data
     * point must be more recent than any other point in its time series.  Each
     * `TimeSeries` value must fully specify a unique time series by supplying
     * all label values for the metric and the monitored resource.
     * The maximum number of `TimeSeries` objects per `Create` request is 200.
     *
     * Generated from protobuf field <code>repeated .google.monitoring.v3.TimeSeries time_series = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getTimeSeries()
    {
        return $this->time_series;
    }

    /**
     * Required. The new data to be added to a list of time series.
     * Adds at most one data point to each of several time series.  The new data
     * point must be more recent than any other point in its time series.  Each
     * `TimeSeries` value must fully specify a unique time series by supplying
     * all label values for the metric and the monitored resource.
     * The maximum number of `TimeSeries` objects per `Create` request is 200.
     *
     * Generated from protobuf field <code>repeated .google.monitoring.v3.TimeSeries time_series = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param array<\Google\Cloud\Monitoring\V3\TimeSeries>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setTimeSeries($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Monitoring\V3\TimeSeries::class);
        $this->time_series = $arr;

        return $this;
    }

}

