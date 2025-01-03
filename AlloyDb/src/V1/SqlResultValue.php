<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/alloydb/v1/data_model.proto

namespace Google\Cloud\AlloyDb\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A single value in a row from a sql result.
 *
 * Generated from protobuf message <code>google.cloud.alloydb.v1.SqlResultValue</code>
 */
class SqlResultValue extends \Google\Protobuf\Internal\Message
{
    /**
     * The cell value represented in string format.
     * Timestamps are converted to string using RFC3339Nano format.
     *
     * Generated from protobuf field <code>optional string value = 1;</code>
     */
    protected $value = null;
    /**
     * Set to true if cell value is null.
     *
     * Generated from protobuf field <code>optional bool null_value = 2;</code>
     */
    protected $null_value = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $value
     *           The cell value represented in string format.
     *           Timestamps are converted to string using RFC3339Nano format.
     *     @type bool $null_value
     *           Set to true if cell value is null.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Alloydb\V1\DataModel::initOnce();
        parent::__construct($data);
    }

    /**
     * The cell value represented in string format.
     * Timestamps are converted to string using RFC3339Nano format.
     *
     * Generated from protobuf field <code>optional string value = 1;</code>
     * @return string
     */
    public function getValue()
    {
        return isset($this->value) ? $this->value : '';
    }

    public function hasValue()
    {
        return isset($this->value);
    }

    public function clearValue()
    {
        unset($this->value);
    }

    /**
     * The cell value represented in string format.
     * Timestamps are converted to string using RFC3339Nano format.
     *
     * Generated from protobuf field <code>optional string value = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->value = $var;

        return $this;
    }

    /**
     * Set to true if cell value is null.
     *
     * Generated from protobuf field <code>optional bool null_value = 2;</code>
     * @return bool
     */
    public function getNullValue()
    {
        return isset($this->null_value) ? $this->null_value : false;
    }

    public function hasNullValue()
    {
        return isset($this->null_value);
    }

    public function clearNullValue()
    {
        unset($this->null_value);
    }

    /**
     * Set to true if cell value is null.
     *
     * Generated from protobuf field <code>optional bool null_value = 2;</code>
     * @param bool $var
     * @return $this
     */
    public function setNullValue($var)
    {
        GPBUtil::checkBool($var);
        $this->null_value = $var;

        return $this;
    }

}

