<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/participant.proto

namespace Google\Cloud\Dialogflow\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The request message for
 * [Participants.SuggestFaqAnswers][google.cloud.dialogflow.v2.Participants.SuggestFaqAnswers].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.SuggestFaqAnswersResponse</code>
 */
class SuggestFaqAnswersResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Answers extracted from FAQ documents.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.FaqAnswer faq_answers = 1;</code>
     */
    private $faq_answers;
    /**
     * The name of the latest conversation message used to compile
     * suggestion for.
     * Format: `projects/<Project ID>/locations/<Location
     * ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *
     * Generated from protobuf field <code>string latest_message = 2;</code>
     */
    protected $latest_message = '';
    /**
     * Number of messages prior to and including
     * [latest_message][google.cloud.dialogflow.v2.SuggestFaqAnswersResponse.latest_message]
     * to compile the suggestion. It may be smaller than the
     * [SuggestFaqAnswersRequest.context_size][google.cloud.dialogflow.v2.SuggestFaqAnswersRequest.context_size]
     * field in the request if there aren't that many messages in the
     * conversation.
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
     *     @type array<\Google\Cloud\Dialogflow\V2\FaqAnswer>|\Google\Protobuf\Internal\RepeatedField $faq_answers
     *           Answers extracted from FAQ documents.
     *     @type string $latest_message
     *           The name of the latest conversation message used to compile
     *           suggestion for.
     *           Format: `projects/<Project ID>/locations/<Location
     *           ID>/conversations/<Conversation ID>/messages/<Message ID>`.
     *     @type int $context_size
     *           Number of messages prior to and including
     *           [latest_message][google.cloud.dialogflow.v2.SuggestFaqAnswersResponse.latest_message]
     *           to compile the suggestion. It may be smaller than the
     *           [SuggestFaqAnswersRequest.context_size][google.cloud.dialogflow.v2.SuggestFaqAnswersRequest.context_size]
     *           field in the request if there aren't that many messages in the
     *           conversation.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Participant::initOnce();
        parent::__construct($data);
    }

    /**
     * Answers extracted from FAQ documents.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.FaqAnswer faq_answers = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFaqAnswers()
    {
        return $this->faq_answers;
    }

    /**
     * Answers extracted from FAQ documents.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.FaqAnswer faq_answers = 1;</code>
     * @param array<\Google\Cloud\Dialogflow\V2\FaqAnswer>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFaqAnswers($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Dialogflow\V2\FaqAnswer::class);
        $this->faq_answers = $arr;

        return $this;
    }

    /**
     * The name of the latest conversation message used to compile
     * suggestion for.
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
     * The name of the latest conversation message used to compile
     * suggestion for.
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
     * [latest_message][google.cloud.dialogflow.v2.SuggestFaqAnswersResponse.latest_message]
     * to compile the suggestion. It may be smaller than the
     * [SuggestFaqAnswersRequest.context_size][google.cloud.dialogflow.v2.SuggestFaqAnswersRequest.context_size]
     * field in the request if there aren't that many messages in the
     * conversation.
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
     * [latest_message][google.cloud.dialogflow.v2.SuggestFaqAnswersResponse.latest_message]
     * to compile the suggestion. It may be smaller than the
     * [SuggestFaqAnswersRequest.context_size][google.cloud.dialogflow.v2.SuggestFaqAnswersRequest.context_size]
     * field in the request if there aren't that many messages in the
     * conversation.
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

