<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/configdelivery/v1beta/config_delivery.proto

namespace Google\Cloud\ConfigDelivery\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Variant represents the content of a `ResourceBundle` variant.
 *
 * Generated from protobuf message <code>google.cloud.configdelivery.v1beta.Variant</code>
 */
class Variant extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. labels to represent any metadata associated with the variant.
     *
     * Generated from protobuf field <code>map<string, string> labels = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $labels;
    /**
     * Required. Input only. Unordered list. resources contain the kubernetes
     * manifests (YAMLs) for this variant.
     *
     * Generated from protobuf field <code>repeated string resources = 2 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = UNORDERED_LIST, (.google.api.field_behavior) = INPUT_ONLY];</code>
     */
    private $resources;
    /**
     * Identifier. Name follows format of
     * projects/{project}/locations/{location}/resourceBundles/{resource_bundle}/releases/{release}/variants/{variant}
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.field_behavior) = IDENTIFIER];</code>
     */
    protected $name = '';
    /**
     * Output only. [Output only] Create time stamp
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $create_time = null;
    /**
     * Output only. [Output only] Update time stamp
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $update_time = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array|\Google\Protobuf\Internal\MapField $labels
     *           Optional. labels to represent any metadata associated with the variant.
     *     @type array<string>|\Google\Protobuf\Internal\RepeatedField $resources
     *           Required. Input only. Unordered list. resources contain the kubernetes
     *           manifests (YAMLs) for this variant.
     *     @type string $name
     *           Identifier. Name follows format of
     *           projects/{project}/locations/{location}/resourceBundles/{resource_bundle}/releases/{release}/variants/{variant}
     *     @type \Google\Protobuf\Timestamp $create_time
     *           Output only. [Output only] Create time stamp
     *     @type \Google\Protobuf\Timestamp $update_time
     *           Output only. [Output only] Update time stamp
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Configdelivery\V1Beta\ConfigDelivery::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. labels to represent any metadata associated with the variant.
     *
     * Generated from protobuf field <code>map<string, string> labels = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * Optional. labels to represent any metadata associated with the variant.
     *
     * Generated from protobuf field <code>map<string, string> labels = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->labels = $arr;

        return $this;
    }

    /**
     * Required. Input only. Unordered list. resources contain the kubernetes
     * manifests (YAMLs) for this variant.
     *
     * Generated from protobuf field <code>repeated string resources = 2 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = UNORDERED_LIST, (.google.api.field_behavior) = INPUT_ONLY];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Required. Input only. Unordered list. resources contain the kubernetes
     * manifests (YAMLs) for this variant.
     *
     * Generated from protobuf field <code>repeated string resources = 2 [(.google.api.field_behavior) = REQUIRED, (.google.api.field_behavior) = UNORDERED_LIST, (.google.api.field_behavior) = INPUT_ONLY];</code>
     * @param array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setResources($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->resources = $arr;

        return $this;
    }

    /**
     * Identifier. Name follows format of
     * projects/{project}/locations/{location}/resourceBundles/{resource_bundle}/releases/{release}/variants/{variant}
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.field_behavior) = IDENTIFIER];</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Identifier. Name follows format of
     * projects/{project}/locations/{location}/resourceBundles/{resource_bundle}/releases/{release}/variants/{variant}
     *
     * Generated from protobuf field <code>string name = 3 [(.google.api.field_behavior) = IDENTIFIER];</code>
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
     * Output only. [Output only] Create time stamp
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    public function hasCreateTime()
    {
        return isset($this->create_time);
    }

    public function clearCreateTime()
    {
        unset($this->create_time);
    }

    /**
     * Output only. [Output only] Create time stamp
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp create_time = 4 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setCreateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->create_time = $var;

        return $this;
    }

    /**
     * Output only. [Output only] Update time stamp
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Protobuf\Timestamp|null
     */
    public function getUpdateTime()
    {
        return $this->update_time;
    }

    public function hasUpdateTime()
    {
        return isset($this->update_time);
    }

    public function clearUpdateTime()
    {
        unset($this->update_time);
    }

    /**
     * Output only. [Output only] Update time stamp
     *
     * Generated from protobuf field <code>.google.protobuf.Timestamp update_time = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Protobuf\Timestamp $var
     * @return $this
     */
    public function setUpdateTime($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Timestamp::class);
        $this->update_time = $var;

        return $this;
    }

}

