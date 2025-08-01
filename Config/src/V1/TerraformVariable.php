<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/config/v1/config.proto

namespace Google\Cloud\Config\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A Terraform input variable.
 *
 * Generated from protobuf message <code>google.cloud.config.v1.TerraformVariable</code>
 */
class TerraformVariable extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. Input variable value.
     *
     * Generated from protobuf field <code>.google.protobuf.Value input_value = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $input_value = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Protobuf\Value $input_value
     *           Optional. Input variable value.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Config\V1\Config::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. Input variable value.
     *
     * Generated from protobuf field <code>.google.protobuf.Value input_value = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Value|null
     */
    public function getInputValue()
    {
        return $this->input_value;
    }

    public function hasInputValue()
    {
        return isset($this->input_value);
    }

    public function clearInputValue()
    {
        unset($this->input_value);
    }

    /**
     * Optional. Input variable value.
     *
     * Generated from protobuf field <code>.google.protobuf.Value input_value = 5 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param \Google\Protobuf\Value $var
     * @return $this
     */
    public function setInputValue($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Value::class);
        $this->input_value = $var;

        return $this;
    }

}

