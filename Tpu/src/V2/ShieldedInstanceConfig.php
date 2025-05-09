<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/tpu/v2/cloud_tpu.proto

namespace Google\Cloud\Tpu\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A set of Shielded Instance options.
 *
 * Generated from protobuf message <code>google.cloud.tpu.v2.ShieldedInstanceConfig</code>
 */
class ShieldedInstanceConfig extends \Google\Protobuf\Internal\Message
{
    /**
     * Defines whether the instance has Secure Boot enabled.
     *
     * Generated from protobuf field <code>bool enable_secure_boot = 1;</code>
     */
    protected $enable_secure_boot = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $enable_secure_boot
     *           Defines whether the instance has Secure Boot enabled.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Tpu\V2\CloudTpu::initOnce();
        parent::__construct($data);
    }

    /**
     * Defines whether the instance has Secure Boot enabled.
     *
     * Generated from protobuf field <code>bool enable_secure_boot = 1;</code>
     * @return bool
     */
    public function getEnableSecureBoot()
    {
        return $this->enable_secure_boot;
    }

    /**
     * Defines whether the instance has Secure Boot enabled.
     *
     * Generated from protobuf field <code>bool enable_secure_boot = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setEnableSecureBoot($var)
    {
        GPBUtil::checkBool($var);
        $this->enable_secure_boot = $var;

        return $this;
    }

}

