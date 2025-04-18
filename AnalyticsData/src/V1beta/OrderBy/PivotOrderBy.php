<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/analytics/data/v1beta/data.proto

namespace Google\Analytics\Data\V1beta\OrderBy;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Sorts by a pivot column group.
 *
 * Generated from protobuf message <code>google.analytics.data.v1beta.OrderBy.PivotOrderBy</code>
 */
class PivotOrderBy extends \Google\Protobuf\Internal\Message
{
    /**
     * In the response to order by, order rows by this column. Must be a metric
     * name from the request.
     *
     * Generated from protobuf field <code>string metric_name = 1;</code>
     */
    protected $metric_name = '';
    /**
     * Used to select a dimension name and value pivot. If multiple pivot
     * selections are given, the sort occurs on rows where all pivot selection
     * dimension name and value pairs match the row's dimension name and value
     * pair.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1beta.OrderBy.PivotOrderBy.PivotSelection pivot_selections = 2;</code>
     */
    private $pivot_selections;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $metric_name
     *           In the response to order by, order rows by this column. Must be a metric
     *           name from the request.
     *     @type array<\Google\Analytics\Data\V1beta\OrderBy\PivotOrderBy\PivotSelection>|\Google\Protobuf\Internal\RepeatedField $pivot_selections
     *           Used to select a dimension name and value pivot. If multiple pivot
     *           selections are given, the sort occurs on rows where all pivot selection
     *           dimension name and value pairs match the row's dimension name and value
     *           pair.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Analytics\Data\V1Beta\Data::initOnce();
        parent::__construct($data);
    }

    /**
     * In the response to order by, order rows by this column. Must be a metric
     * name from the request.
     *
     * Generated from protobuf field <code>string metric_name = 1;</code>
     * @return string
     */
    public function getMetricName()
    {
        return $this->metric_name;
    }

    /**
     * In the response to order by, order rows by this column. Must be a metric
     * name from the request.
     *
     * Generated from protobuf field <code>string metric_name = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMetricName($var)
    {
        GPBUtil::checkString($var, True);
        $this->metric_name = $var;

        return $this;
    }

    /**
     * Used to select a dimension name and value pivot. If multiple pivot
     * selections are given, the sort occurs on rows where all pivot selection
     * dimension name and value pairs match the row's dimension name and value
     * pair.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1beta.OrderBy.PivotOrderBy.PivotSelection pivot_selections = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPivotSelections()
    {
        return $this->pivot_selections;
    }

    /**
     * Used to select a dimension name and value pivot. If multiple pivot
     * selections are given, the sort occurs on rows where all pivot selection
     * dimension name and value pairs match the row's dimension name and value
     * pair.
     *
     * Generated from protobuf field <code>repeated .google.analytics.data.v1beta.OrderBy.PivotOrderBy.PivotSelection pivot_selections = 2;</code>
     * @param array<\Google\Analytics\Data\V1beta\OrderBy\PivotOrderBy\PivotSelection>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPivotSelections($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Analytics\Data\V1beta\OrderBy\PivotOrderBy\PivotSelection::class);
        $this->pivot_selections = $arr;

        return $this;
    }

}


