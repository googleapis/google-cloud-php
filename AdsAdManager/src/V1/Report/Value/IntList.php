<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/admanager/v1/report_messages.proto

namespace Google\Ads\AdManager\V1\Report\Value;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A list of integer values.
 *
 * Generated from protobuf message <code>google.ads.admanager.v1.Report.Value.IntList</code>
 */
class IntList extends \Google\Protobuf\Internal\Message
{
    /**
     * The values
     *
     * Generated from protobuf field <code>repeated int64 values = 1;</code>
     */
    private $values;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<int>|array<string>|\Google\Protobuf\Internal\RepeatedField $values
     *           The values
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\Admanager\V1\ReportMessages::initOnce();
        parent::__construct($data);
    }

    /**
     * The values
     *
     * Generated from protobuf field <code>repeated int64 values = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * The values
     *
     * Generated from protobuf field <code>repeated int64 values = 1;</code>
     * @param array<int>|array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setValues($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::INT64);
        $this->values = $arr;

        return $this;
    }

}


