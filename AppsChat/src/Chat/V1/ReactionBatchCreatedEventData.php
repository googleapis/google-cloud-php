<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/chat/v1/event_payload.proto

namespace Google\Apps\Chat\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Event payload for multiple new reactions.
 * Event type: `google.workspace.chat.reaction.v1.batchCreated`
 *
 * Generated from protobuf message <code>google.chat.v1.ReactionBatchCreatedEventData</code>
 */
class ReactionBatchCreatedEventData extends \Google\Protobuf\Internal\Message
{
    /**
     * A list of new reactions.
     *
     * Generated from protobuf field <code>repeated .google.chat.v1.ReactionCreatedEventData reactions = 1;</code>
     */
    private $reactions;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Apps\Chat\V1\ReactionCreatedEventData>|\Google\Protobuf\Internal\RepeatedField $reactions
     *           A list of new reactions.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Chat\V1\EventPayload::initOnce();
        parent::__construct($data);
    }

    /**
     * A list of new reactions.
     *
     * Generated from protobuf field <code>repeated .google.chat.v1.ReactionCreatedEventData reactions = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getReactions()
    {
        return $this->reactions;
    }

    /**
     * A list of new reactions.
     *
     * Generated from protobuf field <code>repeated .google.chat.v1.ReactionCreatedEventData reactions = 1;</code>
     * @param array<\Google\Apps\Chat\V1\ReactionCreatedEventData>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setReactions($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Apps\Chat\V1\ReactionCreatedEventData::class);
        $this->reactions = $arr;

        return $this;
    }

}

