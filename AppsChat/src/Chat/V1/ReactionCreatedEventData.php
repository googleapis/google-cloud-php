<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/chat/v1/event_payload.proto

namespace Google\Apps\Chat\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Event payload for a new reaction.
 * Event type: `google.workspace.chat.reaction.v1.created`
 *
 * Generated from protobuf message <code>google.chat.v1.ReactionCreatedEventData</code>
 */
class ReactionCreatedEventData extends \Google\Protobuf\Internal\Message
{
    /**
     * The new reaction.
     *
     * Generated from protobuf field <code>.google.chat.v1.Reaction reaction = 1;</code>
     */
    protected $reaction = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Apps\Chat\V1\Reaction $reaction
     *           The new reaction.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Chat\V1\EventPayload::initOnce();
        parent::__construct($data);
    }

    /**
     * The new reaction.
     *
     * Generated from protobuf field <code>.google.chat.v1.Reaction reaction = 1;</code>
     * @return \Google\Apps\Chat\V1\Reaction|null
     */
    public function getReaction()
    {
        return $this->reaction;
    }

    public function hasReaction()
    {
        return isset($this->reaction);
    }

    public function clearReaction()
    {
        unset($this->reaction);
    }

    /**
     * The new reaction.
     *
     * Generated from protobuf field <code>.google.chat.v1.Reaction reaction = 1;</code>
     * @param \Google\Apps\Chat\V1\Reaction $var
     * @return $this
     */
    public function setReaction($var)
    {
        GPBUtil::checkMessage($var, \Google\Apps\Chat\V1\Reaction::class);
        $this->reaction = $var;

        return $this;
    }

}

