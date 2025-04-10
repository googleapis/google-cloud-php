<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/participant.proto

namespace Google\Cloud\Dialogflow\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The response message for
 * [Participants.SuggestKnowledgeAssist][google.cloud.dialogflow.v2.Participants.SuggestKnowledgeAssist].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.SuggestKnowledgeAssistResponse</code>
 */
class SuggestKnowledgeAssistResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. Knowledge Assist suggestion.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer knowledge_assist_answer = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $knowledge_assist_answer = null;
    /**
     * The name of the latest conversation message used to compile suggestion for.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *
     * Generated from protobuf field <code>string latest_message = 2;</code>
     */
    protected $latest_message = '';
    /**
     * Number of messages prior to and including
     * [latest_message][google.cloud.dialogflow.v2.SuggestKnowledgeAssistResponse.latest_message]
     * to compile the suggestion. It may be smaller than the
     * [SuggestKnowledgeAssistRequest.context_size][google.cloud.dialogflow.v2.SuggestKnowledgeAssistRequest.context_size]
     * field in the request if there are fewer messages in the conversation.
     *
     * Generated from protobuf field <code>int32 context_size = 3;</code>
     */
    protected $context_size = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer $knowledge_assist_answer
     *           Output only. Knowledge Assist suggestion.
     *     @type string $latest_message
     *           The name of the latest conversation message used to compile suggestion for.
     *           Format: `projects/<Project ID>/locations/<Location
     *           ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *     @type int $context_size
     *           Number of messages prior to and including
     *           [latest_message][google.cloud.dialogflow.v2.SuggestKnowledgeAssistResponse.latest_message]
     *           to compile the suggestion. It may be smaller than the
     *           [SuggestKnowledgeAssistRequest.context_size][google.cloud.dialogflow.v2.SuggestKnowledgeAssistRequest.context_size]
     *           field in the request if there are fewer messages in the conversation.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Participant::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. Knowledge Assist suggestion.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer knowledge_assist_answer = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer|null
     */
    public function getKnowledgeAssistAnswer()
    {
        return $this->knowledge_assist_answer;
    }

    public function hasKnowledgeAssistAnswer()
    {
        return isset($this->knowledge_assist_answer);
    }

    public function clearKnowledgeAssistAnswer()
    {
        unset($this->knowledge_assist_answer);
    }

    /**
     * Output only. Knowledge Assist suggestion.
     *
     * Generated from protobuf field <code>.google.cloud.dialogflow.v2.KnowledgeAssistAnswer knowledge_assist_answer = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer $var
     * @return $this
     */
    public function setKnowledgeAssistAnswer($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Dialogflow\V2\KnowledgeAssistAnswer::class);
        $this->knowledge_assist_answer = $var;

        return $this;
    }

    /**
     * The name of the latest conversation message used to compile suggestion for.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *
     * Generated from protobuf field <code>string latest_message = 2;</code>
     * @return string
     */
    public function getLatestMessage()
    {
        return $this->latest_message;
    }

    /**
     * The name of the latest conversation message used to compile suggestion for.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *
     * Generated from protobuf field <code>string latest_message = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setLatestMessage($var)
    {
        GPBUtil::checkString($var, True);
        $this->latest_message = $var;

        return $this;
    }

    /**
     * Number of messages prior to and including
     * [latest_message][google.cloud.dialogflow.v2.SuggestKnowledgeAssistResponse.latest_message]
     * to compile the suggestion. It may be smaller than the
     * [SuggestKnowledgeAssistRequest.context_size][google.cloud.dialogflow.v2.SuggestKnowledgeAssistRequest.context_size]
     * field in the request if there are fewer messages in the conversation.
     *
     * Generated from protobuf field <code>int32 context_size = 3;</code>
     * @return int
     */
    public function getContextSize()
    {
        return $this->context_size;
    }

    /**
     * Number of messages prior to and including
     * [latest_message][google.cloud.dialogflow.v2.SuggestKnowledgeAssistResponse.latest_message]
     * to compile the suggestion. It may be smaller than the
     * [SuggestKnowledgeAssistRequest.context_size][google.cloud.dialogflow.v2.SuggestKnowledgeAssistRequest.context_size]
     * field in the request if there are fewer messages in the conversation.
     *
     * Generated from protobuf field <code>int32 context_size = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setContextSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->context_size = $var;

        return $this;
    }

}

