<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/geminidataanalytics/v1beta/data_chat_service.proto

namespace Google\Cloud\GeminiDataAnalytics\V1beta;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response for listing chat messages.
 *
 * Generated from protobuf message <code>google.cloud.geminidataanalytics.v1beta.ListMessagesResponse</code>
 */
class ListMessagesResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The list of chat messages.
     *
     * Generated from protobuf field <code>repeated .google.cloud.geminidataanalytics.v1beta.StorageMessage messages = 1;</code>
     */
    private $messages;
    /**
     * A token identifying a page of results the server should return.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    protected $next_page_token = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\GeminiDataAnalytics\V1beta\StorageMessage>|\Google\Protobuf\Internal\RepeatedField $messages
     *           The list of chat messages.
     *     @type string $next_page_token
     *           A token identifying a page of results the server should return.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Geminidataanalytics\V1Beta\DataChatService::initOnce();
        parent::__construct($data);
    }

    /**
     * The list of chat messages.
     *
     * Generated from protobuf field <code>repeated .google.cloud.geminidataanalytics.v1beta.StorageMessage messages = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * The list of chat messages.
     *
     * Generated from protobuf field <code>repeated .google.cloud.geminidataanalytics.v1beta.StorageMessage messages = 1;</code>
     * @param array<\Google\Cloud\GeminiDataAnalytics\V1beta\StorageMessage>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setMessages($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\GeminiDataAnalytics\V1beta\StorageMessage::class);
        $this->messages = $arr;

        return $this;
    }

    /**
     * A token identifying a page of results the server should return.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * A token identifying a page of results the server should return.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setNextPageToken($var)
    {
        GPBUtil::checkString($var, True);
        $this->next_page_token = $var;

        return $this;
    }

}

