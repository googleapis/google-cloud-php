<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/reasoning_engine_service.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [ReasoningEngineService.DeleteReasoningEngine][google.cloud.aiplatform.v1.ReasoningEngineService.DeleteReasoningEngine].
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.DeleteReasoningEngineRequest</code>
 */
class DeleteReasoningEngineRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The name of the ReasoningEngine resource to be deleted.
     * Format:
     * `projects/{project}/locations/{location}/reasoningEngines/{reasoning_engine}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * Optional. If set to true, child resources of this reasoning engine will
     * also be deleted. Otherwise, the request will fail with FAILED_PRECONDITION
     * error when the reasoning engine has undeleted child resources.
     *
     * Generated from protobuf field <code>bool force = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $force = false;

    /**
     * @param string $name Required. The name of the ReasoningEngine resource to be deleted.
     *                     Format:
     *                     `projects/{project}/locations/{location}/reasoningEngines/{reasoning_engine}`
     *                     Please see {@see ReasoningEngineServiceClient::reasoningEngineName()} for help formatting this field.
     *
     * @return \Google\Cloud\AIPlatform\V1\DeleteReasoningEngineRequest
     *
     * @experimental
     */
    public static function build(string $name): self
    {
        return (new self())
            ->setName($name);
    }

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $name
     *           Required. The name of the ReasoningEngine resource to be deleted.
     *           Format:
     *           `projects/{project}/locations/{location}/reasoningEngines/{reasoning_engine}`
     *     @type bool $force
     *           Optional. If set to true, child resources of this reasoning engine will
     *           also be deleted. Otherwise, the request will fail with FAILED_PRECONDITION
     *           error when the reasoning engine has undeleted child resources.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\ReasoningEngineService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The name of the ReasoningEngine resource to be deleted.
     * Format:
     * `projects/{project}/locations/{location}/reasoningEngines/{reasoning_engine}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The name of the ReasoningEngine resource to be deleted.
     * Format:
     * `projects/{project}/locations/{location}/reasoningEngines/{reasoning_engine}`
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
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
     * Optional. If set to true, child resources of this reasoning engine will
     * also be deleted. Otherwise, the request will fail with FAILED_PRECONDITION
     * error when the reasoning engine has undeleted child resources.
     *
     * Generated from protobuf field <code>bool force = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return bool
     */
    public function getForce()
    {
        return $this->force;
    }

    /**
     * Optional. If set to true, child resources of this reasoning engine will
     * also be deleted. Otherwise, the request will fail with FAILED_PRECONDITION
     * error when the reasoning engine has undeleted child resources.
     *
     * Generated from protobuf field <code>bool force = 2 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param bool $var
     * @return $this
     */
    public function setForce($var)
    {
        GPBUtil::checkBool($var);
        $this->force = $var;

        return $this;
    }

}

