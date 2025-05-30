<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/contactcenterinsights/v1/contact_center_insights.proto

namespace Google\Cloud\ContactCenterInsights\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request for querying metrics.
 *
 * Generated from protobuf message <code>google.cloud.contactcenterinsights.v1.QueryMetricsRequest</code>
 */
class QueryMetricsRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The location of the data.
     * "projects/{project}/locations/{location}"
     *
     * Generated from protobuf field <code>string location = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $location = '';
    /**
     * Required. Filter to select a subset of conversations to compute the
     * metrics. Must specify a window of the conversation create time to compute
     * the metrics. The returned metrics will be from the range [DATE(starting
     * create time), DATE(ending create time)).
     *
     * Generated from protobuf field <code>string filter = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $filter = '';
    /**
     * The time granularity of each data point in the time series.
     * Defaults to NONE if this field is unspecified.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.QueryMetricsRequest.TimeGranularity time_granularity = 3;</code>
     */
    protected $time_granularity = 0;
    /**
     * The dimensions that determine the grouping key for the query. Defaults to
     * no dimension if this field is unspecified. If a dimension is specified,
     * its key must also be specified. Each dimension's key must be unique.
     * If a time granularity is also specified, metric values in the dimension
     * will be bucketed by this granularity.
     * Up to one dimension is supported for now.
     *
     * Generated from protobuf field <code>repeated .google.cloud.contactcenterinsights.v1.Dimension dimensions = 4;</code>
     */
    private $dimensions;
    /**
     * Measures to return. Defaults to all measures if this field is unspecified.
     * A valid mask should traverse from the `measure` field from the response.
     * For example, a path from a measure mask to get the conversation count is
     * "conversation_measure.count".
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask measure_mask = 5;</code>
     */
    protected $measure_mask = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $location
     *           Required. The location of the data.
     *           "projects/{project}/locations/{location}"
     *     @type string $filter
     *           Required. Filter to select a subset of conversations to compute the
     *           metrics. Must specify a window of the conversation create time to compute
     *           the metrics. The returned metrics will be from the range [DATE(starting
     *           create time), DATE(ending create time)).
     *     @type int $time_granularity
     *           The time granularity of each data point in the time series.
     *           Defaults to NONE if this field is unspecified.
     *     @type array<\Google\Cloud\ContactCenterInsights\V1\Dimension>|\Google\Protobuf\Internal\RepeatedField $dimensions
     *           The dimensions that determine the grouping key for the query. Defaults to
     *           no dimension if this field is unspecified. If a dimension is specified,
     *           its key must also be specified. Each dimension's key must be unique.
     *           If a time granularity is also specified, metric values in the dimension
     *           will be bucketed by this granularity.
     *           Up to one dimension is supported for now.
     *     @type \Google\Protobuf\FieldMask $measure_mask
     *           Measures to return. Defaults to all measures if this field is unspecified.
     *           A valid mask should traverse from the `measure` field from the response.
     *           For example, a path from a measure mask to get the conversation count is
     *           "conversation_measure.count".
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Contactcenterinsights\V1\ContactCenterInsights::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The location of the data.
     * "projects/{project}/locations/{location}"
     *
     * Generated from protobuf field <code>string location = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Required. The location of the data.
     * "projects/{project}/locations/{location}"
     *
     * Generated from protobuf field <code>string location = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @param string $var
     * @return $this
     */
    public function setLocation($var)
    {
        GPBUtil::checkString($var, True);
        $this->location = $var;

        return $this;
    }

    /**
     * Required. Filter to select a subset of conversations to compute the
     * metrics. Must specify a window of the conversation create time to compute
     * the metrics. The returned metrics will be from the range [DATE(starting
     * create time), DATE(ending create time)).
     *
     * Generated from protobuf field <code>string filter = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Required. Filter to select a subset of conversations to compute the
     * metrics. Must specify a window of the conversation create time to compute
     * the metrics. The returned metrics will be from the range [DATE(starting
     * create time), DATE(ending create time)).
     *
     * Generated from protobuf field <code>string filter = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setFilter($var)
    {
        GPBUtil::checkString($var, True);
        $this->filter = $var;

        return $this;
    }

    /**
     * The time granularity of each data point in the time series.
     * Defaults to NONE if this field is unspecified.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.QueryMetricsRequest.TimeGranularity time_granularity = 3;</code>
     * @return int
     */
    public function getTimeGranularity()
    {
        return $this->time_granularity;
    }

    /**
     * The time granularity of each data point in the time series.
     * Defaults to NONE if this field is unspecified.
     *
     * Generated from protobuf field <code>.google.cloud.contactcenterinsights.v1.QueryMetricsRequest.TimeGranularity time_granularity = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setTimeGranularity($var)
    {
        GPBUtil::checkEnum($var, \Google\Cloud\ContactCenterInsights\V1\QueryMetricsRequest\TimeGranularity::class);
        $this->time_granularity = $var;

        return $this;
    }

    /**
     * The dimensions that determine the grouping key for the query. Defaults to
     * no dimension if this field is unspecified. If a dimension is specified,
     * its key must also be specified. Each dimension's key must be unique.
     * If a time granularity is also specified, metric values in the dimension
     * will be bucketed by this granularity.
     * Up to one dimension is supported for now.
     *
     * Generated from protobuf field <code>repeated .google.cloud.contactcenterinsights.v1.Dimension dimensions = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * The dimensions that determine the grouping key for the query. Defaults to
     * no dimension if this field is unspecified. If a dimension is specified,
     * its key must also be specified. Each dimension's key must be unique.
     * If a time granularity is also specified, metric values in the dimension
     * will be bucketed by this granularity.
     * Up to one dimension is supported for now.
     *
     * Generated from protobuf field <code>repeated .google.cloud.contactcenterinsights.v1.Dimension dimensions = 4;</code>
     * @param array<\Google\Cloud\ContactCenterInsights\V1\Dimension>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setDimensions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\ContactCenterInsights\V1\Dimension::class);
        $this->dimensions = $arr;

        return $this;
    }

    /**
     * Measures to return. Defaults to all measures if this field is unspecified.
     * A valid mask should traverse from the `measure` field from the response.
     * For example, a path from a measure mask to get the conversation count is
     * "conversation_measure.count".
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask measure_mask = 5;</code>
     * @return \Google\Protobuf\FieldMask|null
     */
    public function getMeasureMask()
    {
        return $this->measure_mask;
    }

    public function hasMeasureMask()
    {
        return isset($this->measure_mask);
    }

    public function clearMeasureMask()
    {
        unset($this->measure_mask);
    }

    /**
     * Measures to return. Defaults to all measures if this field is unspecified.
     * A valid mask should traverse from the `measure` field from the response.
     * For example, a path from a measure mask to get the conversation count is
     * "conversation_measure.count".
     *
     * Generated from protobuf field <code>.google.protobuf.FieldMask measure_mask = 5;</code>
     * @param \Google\Protobuf\FieldMask $var
     * @return $this
     */
    public function setMeasureMask($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\FieldMask::class);
        $this->measure_mask = $var;

        return $this;
    }

}

