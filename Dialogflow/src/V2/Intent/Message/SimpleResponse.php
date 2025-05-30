<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/dialogflow/v2/intent.proto

namespace Google\Cloud\Dialogflow\V2\Intent\Message;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * The simple response message containing speech or text.
 *
 * Generated from protobuf message <code>google.cloud.dialogflow.v2.Intent.Message.SimpleResponse</code>
 */
class SimpleResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * One of text_to_speech or ssml must be provided. The plain text of the
     * speech output. Mutually exclusive with ssml.
     *
     * Generated from protobuf field <code>string text_to_speech = 1;</code>
     */
    protected $text_to_speech = '';
    /**
     * One of text_to_speech or ssml must be provided. Structured spoken
     * response to the user in the SSML format. Mutually exclusive with
     * text_to_speech.
     *
     * Generated from protobuf field <code>string ssml = 2;</code>
     */
    protected $ssml = '';
    /**
     * Optional. The text to display.
     *
     * Generated from protobuf field <code>string display_text = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    protected $display_text = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $text_to_speech
     *           One of text_to_speech or ssml must be provided. The plain text of the
     *           speech output. Mutually exclusive with ssml.
     *     @type string $ssml
     *           One of text_to_speech or ssml must be provided. Structured spoken
     *           response to the user in the SSML format. Mutually exclusive with
     *           text_to_speech.
     *     @type string $display_text
     *           Optional. The text to display.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Dialogflow\V2\Intent::initOnce();
        parent::__construct($data);
    }

    /**
     * One of text_to_speech or ssml must be provided. The plain text of the
     * speech output. Mutually exclusive with ssml.
     *
     * Generated from protobuf field <code>string text_to_speech = 1;</code>
     * @return string
     */
    public function getTextToSpeech()
    {
        return $this->text_to_speech;
    }

    /**
     * One of text_to_speech or ssml must be provided. The plain text of the
     * speech output. Mutually exclusive with ssml.
     *
     * Generated from protobuf field <code>string text_to_speech = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setTextToSpeech($var)
    {
        GPBUtil::checkString($var, True);
        $this->text_to_speech = $var;

        return $this;
    }

    /**
     * One of text_to_speech or ssml must be provided. Structured spoken
     * response to the user in the SSML format. Mutually exclusive with
     * text_to_speech.
     *
     * Generated from protobuf field <code>string ssml = 2;</code>
     * @return string
     */
    public function getSsml()
    {
        return $this->ssml;
    }

    /**
     * One of text_to_speech or ssml must be provided. Structured spoken
     * response to the user in the SSML format. Mutually exclusive with
     * text_to_speech.
     *
     * Generated from protobuf field <code>string ssml = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setSsml($var)
    {
        GPBUtil::checkString($var, True);
        $this->ssml = $var;

        return $this;
    }

    /**
     * Optional. The text to display.
     *
     * Generated from protobuf field <code>string display_text = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return string
     */
    public function getDisplayText()
    {
        return $this->display_text;
    }

    /**
     * Optional. The text to display.
     *
     * Generated from protobuf field <code>string display_text = 3 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param string $var
     * @return $this
     */
    public function setDisplayText($var)
    {
        GPBUtil::checkString($var, True);
        $this->display_text = $var;

        return $this;
    }

}


