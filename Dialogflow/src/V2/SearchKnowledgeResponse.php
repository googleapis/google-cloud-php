<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/conversation.proto

namespace Google\Cloud\Dialogflow\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The response message for
 * [Conversations.SearchKnowledge][google.cloud.dialogflow.v2.Conversations.SearchKnowledge].
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.SearchKnowledgeResponse</code>
 */
class SearchKnowledgeResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Most relevant snippets extracted from articles in the given knowledge base,
     * ordered by confidence.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.SearchKnowledgeAnswer answers = 2;</code>
     */
    private $answers;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Dialogflow\V2\SearchKnowledgeAnswer>|\Google\Protobuf\Internal\RepeatedField $answers
     *           Most relevant snippets extracted from articles in the given knowledge base,
     *           ordered by confidence.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Conversation::initOnce();
        parent::__construct($data);
    }

    /**
     * Most relevant snippets extracted from articles in the given knowledge base,
     * ordered by confidence.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.SearchKnowledgeAnswer answers = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Most relevant snippets extracted from articles in the given knowledge base,
     * ordered by confidence.
     *
     * Generated from protobuf field <code>repeated .google.cloud.dialogflow.v2.SearchKnowledgeAnswer answers = 2;</code>
     * @param array<\Google\Cloud\Dialogflow\V2\SearchKnowledgeAnswer>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAnswers($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Dialogflow\V2\SearchKnowledgeAnswer::class);
        $this->answers = $arr;

        return $this;
    }

}
