<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/grounded_generation_service.proto

namespace Google\Cloud\DiscoveryEngine\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Top-level message sent by the client for the `GenerateGroundedContent`
 * method.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.GenerateGroundedContentRequest</code>
 */
class GenerateGroundedContentRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. Location resource.
     * Format: `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string location = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     */
    protected $location = '';
    /**
     * Content of the system instruction for the current API.
     * These instructions will take priority over any other prompt instructions
     * if the selected model is supporting them.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GroundedGenerationContent system_instruction = 5;</code>
     */
    protected $system_instruction = null;
    /**
     * Content of the current conversation with the model.
     * For single-turn queries, this is a single instance. For multi-turn queries,
     * this is a repeated field that contains conversation history + latest
     * request.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.GroundedGenerationContent contents = 2;</code>
     */
    private $contents;
    /**
     * Content generation specification.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GenerateGroundedContentRequest.GenerationSpec generation_spec = 3;</code>
     */
    protected $generation_spec = null;
    /**
     * Grounding specification.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GenerateGroundedContentRequest.GroundingSpec grounding_spec = 4;</code>
     */
    protected $grounding_spec = null;
    /**
     * The user labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 6;</code>
     */
    private $user_labels;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $location
     *           Required. Location resource.
     *           Format: `projects/{project}/locations/{location}`.
     *     @type \Google\Cloud\DiscoveryEngine\V1\GroundedGenerationContent $system_instruction
     *           Content of the system instruction for the current API.
     *           These instructions will take priority over any other prompt instructions
     *           if the selected model is supporting them.
     *     @type array<\Google\Cloud\DiscoveryEngine\V1\GroundedGenerationContent>|\Google\Protobuf\Internal\RepeatedField $contents
     *           Content of the current conversation with the model.
     *           For single-turn queries, this is a single instance. For multi-turn queries,
     *           this is a repeated field that contains conversation history + latest
     *           request.
     *     @type \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GenerationSpec $generation_spec
     *           Content generation specification.
     *     @type \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GroundingSpec $grounding_spec
     *           Grounding specification.
     *     @type array|\Google\Protobuf\Internal\MapField $user_labels
     *           The user labels applied to a resource must meet the following requirements:
     *           * Each resource can have multiple labels, up to a maximum of 64.
     *           * Each label must be a key-value pair.
     *           * Keys have a minimum length of 1 character and a maximum length of 63
     *             characters and cannot be empty. Values can be empty and have a maximum
     *             length of 63 characters.
     *           * Keys and values can contain only lowercase letters, numeric characters,
     *             underscores, and dashes. All characters must use UTF-8 encoding, and
     *             international characters are allowed.
     *           * The key portion of a label must be unique. However, you can use the same
     *             key with multiple resources.
     *           * Keys must start with a lowercase letter or international character.
     *           See [Google Cloud
     *           Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     *           for more details.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\GroundedGenerationService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. Location resource.
     * Format: `projects/{project}/locations/{location}`.
     *
     * Generated from protobuf field <code>string location = 1 [(.google.api.field_behavior) = REQUIRED, (.google.api.resource_reference) = {</code>
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * Required. Location resource.
     * Format: `projects/{project}/locations/{location}`.
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
     * Content of the system instruction for the current API.
     * These instructions will take priority over any other prompt instructions
     * if the selected model is supporting them.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GroundedGenerationContent system_instruction = 5;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\GroundedGenerationContent|null
     */
    public function getSystemInstruction()
    {
        return $this->system_instruction;
    }

    public function hasSystemInstruction()
    {
        return isset($this->system_instruction);
    }

    public function clearSystemInstruction()
    {
        unset($this->system_instruction);
    }

    /**
     * Content of the system instruction for the current API.
     * These instructions will take priority over any other prompt instructions
     * if the selected model is supporting them.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GroundedGenerationContent system_instruction = 5;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\GroundedGenerationContent $var
     * @return $this
     */
    public function setSystemInstruction($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\GroundedGenerationContent::class);
        $this->system_instruction = $var;

        return $this;
    }

    /**
     * Content of the current conversation with the model.
     * For single-turn queries, this is a single instance. For multi-turn queries,
     * this is a repeated field that contains conversation history + latest
     * request.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.GroundedGenerationContent contents = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Content of the current conversation with the model.
     * For single-turn queries, this is a single instance. For multi-turn queries,
     * this is a repeated field that contains conversation history + latest
     * request.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.GroundedGenerationContent contents = 2;</code>
     * @param array<\Google\Cloud\DiscoveryEngine\V1\GroundedGenerationContent>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setContents($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\DiscoveryEngine\V1\GroundedGenerationContent::class);
        $this->contents = $arr;

        return $this;
    }

    /**
     * Content generation specification.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GenerateGroundedContentRequest.GenerationSpec generation_spec = 3;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GenerationSpec|null
     */
    public function getGenerationSpec()
    {
        return $this->generation_spec;
    }

    public function hasGenerationSpec()
    {
        return isset($this->generation_spec);
    }

    public function clearGenerationSpec()
    {
        unset($this->generation_spec);
    }

    /**
     * Content generation specification.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GenerateGroundedContentRequest.GenerationSpec generation_spec = 3;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GenerationSpec $var
     * @return $this
     */
    public function setGenerationSpec($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GenerationSpec::class);
        $this->generation_spec = $var;

        return $this;
    }

    /**
     * Grounding specification.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GenerateGroundedContentRequest.GroundingSpec grounding_spec = 4;</code>
     * @return \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GroundingSpec|null
     */
    public function getGroundingSpec()
    {
        return $this->grounding_spec;
    }

    public function hasGroundingSpec()
    {
        return isset($this->grounding_spec);
    }

    public function clearGroundingSpec()
    {
        unset($this->grounding_spec);
    }

    /**
     * Grounding specification.
     *
     * Generated from protobuf field <code>.google.cloud.discoveryengine.v1.GenerateGroundedContentRequest.GroundingSpec grounding_spec = 4;</code>
     * @param \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GroundingSpec $var
     * @return $this
     */
    public function setGroundingSpec($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\DiscoveryEngine\V1\GenerateGroundedContentRequest\GroundingSpec::class);
        $this->grounding_spec = $var;

        return $this;
    }

    /**
     * The user labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 6;</code>
     * @return \Google\Protobuf\Internal\MapField
     */
    public function getUserLabels()
    {
        return $this->user_labels;
    }

    /**
     * The user labels applied to a resource must meet the following requirements:
     * * Each resource can have multiple labels, up to a maximum of 64.
     * * Each label must be a key-value pair.
     * * Keys have a minimum length of 1 character and a maximum length of 63
     *   characters and cannot be empty. Values can be empty and have a maximum
     *   length of 63 characters.
     * * Keys and values can contain only lowercase letters, numeric characters,
     *   underscores, and dashes. All characters must use UTF-8 encoding, and
     *   international characters are allowed.
     * * The key portion of a label must be unique. However, you can use the same
     *   key with multiple resources.
     * * Keys must start with a lowercase letter or international character.
     * See [Google Cloud
     * Document](https://cloud.google.com/resource-manager/docs/creating-managing-labels#requirements)
     * for more details.
     *
     * Generated from protobuf field <code>map<string, string> user_labels = 6;</code>
     * @param array|\Google\Protobuf\Internal\MapField $var
     * @return $this
     */
    public function setUserLabels($var)
    {
        $arr = GPBUtil::checkMapField($var, \Google\Protobuf\Internal\GPBType::STRING, \Google\Protobuf\Internal\GPBType::STRING);
        $this->user_labels = $arr;

        return $this;
    }

}

