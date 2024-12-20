<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/cx/v3/agent.proto

namespace Google\Cloud\Dialogflow\Cx\V3;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request message for
 * [Agents.GetAgentValidationResult][google.cloud.dialogflow.cx.v3.Agents.GetAgentValidationResult].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.cx.v3.GetAgentValidationResultRequest</code>
 */
class GetAgentValidationResultRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The agent name.
     * Format:
     * `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/validationResult`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $name = '';
    /**
     * If not specified, the agent's default language is used.
     *
     * Generated from protobuf field <code>string language_code = 2;</code>
     */
    protected $language_code = '';

    /**
     * @param string $name Required. The agent name.
     *                     Format:
     *                     `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/validationResult`. Please see
     *                     {@see AgentsClient::agentValidationResultName()} for help formatting this field.
     *
     * @return \Google\Cloud\Dialogflow\Cx\V3\GetAgentValidationResultRequest
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
     *           Required. The agent name.
     *           Format:
     *           `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/validationResult`.
     *     @type string $language_code
     *           If not specified, the agent's default language is used.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\Cx\V3\Agent::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The agent name.
     * Format:
     * `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/validationResult`.
     *
     * Generated from protobuf field <code>string name = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Required. The agent name.
     * Format:
     * `projects/<ProjectID>/locations/<LocationID>/agents/<AgentID>/validationResult`.
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
     * If not specified, the agent's default language is used.
     *
     * Generated from protobuf field <code>string language_code = 2;</code>
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->language_code;
    }

    /**
     * If not specified, the agent's default language is used.
     *
     * Generated from protobuf field <code>string language_code = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLanguageCode($var)
    {
        GPBUtil::checkString($var, True);
        $this->language_code = $var;

        return $this;
    }

}

