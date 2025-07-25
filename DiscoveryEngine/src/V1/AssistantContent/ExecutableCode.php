<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/assist_answer.proto

namespace Google\Cloud\DiscoveryEngine\V1\AssistantContent;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Code generated by the model that is meant to be executed by the model.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.AssistantContent.ExecutableCode</code>
 */
class ExecutableCode extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The code content. Currently only supports Python.
     *
     * Generated from protobuf field <code>string code = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $code = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $code
     *           Required. The code content. Currently only supports Python.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\AssistAnswer::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The code content. Currently only supports Python.
     *
     * Generated from protobuf field <code>string code = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Required. The code content. Currently only supports Python.
     *
     * Generated from protobuf field <code>string code = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->code = $var;

        return $this;
    }

}


