<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/speech/v2/cloud_speech.proto

namespace Google\Cloud\Speech\V2;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A speech recognition result corresponding to a portion of the audio.
 *
 * Generated from protobuf message <code>google.cloud.speech.v2.SpeechRecognitionResult</code>
 */
class SpeechRecognitionResult extends \Google\Protobuf\Internal\Message
{
    /**
     * May contain one or more recognition hypotheses. These alternatives are
     * ordered in terms of accuracy, with the top (first) alternative being the
     * most probable, as ranked by the recognizer.
     *
     * Generated from protobuf field <code>repeated .google.cloud.speech.v2.SpeechRecognitionAlternative alternatives = 1;</code>
     */
    private $alternatives;
    /**
     * For multi-channel audio, this is the channel number corresponding to the
     * recognized result for the audio from that channel.
     * For `audio_channel_count` = `N`, its output values can range from `1` to
     * `N`.
     *
     * Generated from protobuf field <code>int32 channel_tag = 2;</code>
     */
    protected $channel_tag = 0;
    /**
     * Time offset of the end of this result relative to the beginning of the
     * audio.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration result_end_offset = 4;</code>
     */
    protected $result_end_offset = null;
    /**
     * Output only. The [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt)
     * language tag of the language in this result. This language code was
     * detected to have the most likelihood of being spoken in the audio.
     *
     * Generated from protobuf field <code>string language_code = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    protected $language_code = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\Speech\V2\SpeechRecognitionAlternative>|\Google\Protobuf\Internal\RepeatedField $alternatives
     *           May contain one or more recognition hypotheses. These alternatives are
     *           ordered in terms of accuracy, with the top (first) alternative being the
     *           most probable, as ranked by the recognizer.
     *     @type int $channel_tag
     *           For multi-channel audio, this is the channel number corresponding to the
     *           recognized result for the audio from that channel.
     *           For `audio_channel_count` = `N`, its output values can range from `1` to
     *           `N`.
     *     @type \Google\Protobuf\Duration $result_end_offset
     *           Time offset of the end of this result relative to the beginning of the
     *           audio.
     *     @type string $language_code
     *           Output only. The [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt)
     *           language tag of the language in this result. This language code was
     *           detected to have the most likelihood of being spoken in the audio.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Speech\V2\CloudSpeech::initOnce();
        parent::__construct($data);
    }

    /**
     * May contain one or more recognition hypotheses. These alternatives are
     * ordered in terms of accuracy, with the top (first) alternative being the
     * most probable, as ranked by the recognizer.
     *
     * Generated from protobuf field <code>repeated .google.cloud.speech.v2.SpeechRecognitionAlternative alternatives = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAlternatives()
    {
        return $this->alternatives;
    }

    /**
     * May contain one or more recognition hypotheses. These alternatives are
     * ordered in terms of accuracy, with the top (first) alternative being the
     * most probable, as ranked by the recognizer.
     *
     * Generated from protobuf field <code>repeated .google.cloud.speech.v2.SpeechRecognitionAlternative alternatives = 1;</code>
     * @param array<\Google\Cloud\Speech\V2\SpeechRecognitionAlternative>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAlternatives($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Speech\V2\SpeechRecognitionAlternative::class);
        $this->alternatives = $arr;

        return $this;
    }

    /**
     * For multi-channel audio, this is the channel number corresponding to the
     * recognized result for the audio from that channel.
     * For `audio_channel_count` = `N`, its output values can range from `1` to
     * `N`.
     *
     * Generated from protobuf field <code>int32 channel_tag = 2;</code>
     * @return int
     */
    public function getChannelTag()
    {
        return $this->channel_tag;
    }

    /**
     * For multi-channel audio, this is the channel number corresponding to the
     * recognized result for the audio from that channel.
     * For `audio_channel_count` = `N`, its output values can range from `1` to
     * `N`.
     *
     * Generated from protobuf field <code>int32 channel_tag = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setChannelTag($var)
    {
        GPBUtil::checkInt32($var);
        $this->channel_tag = $var;

        return $this;
    }

    /**
     * Time offset of the end of this result relative to the beginning of the
     * audio.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration result_end_offset = 4;</code>
     * @return \Google\Protobuf\Duration|null
     */
    public function getResultEndOffset()
    {
        return $this->result_end_offset;
    }

    public function hasResultEndOffset()
    {
        return isset($this->result_end_offset);
    }

    public function clearResultEndOffset()
    {
        unset($this->result_end_offset);
    }

    /**
     * Time offset of the end of this result relative to the beginning of the
     * audio.
     *
     * Generated from protobuf field <code>.google.protobuf.Duration result_end_offset = 4;</code>
     * @param \Google\Protobuf\Duration $var
     * @return $this
     */
    public function setResultEndOffset($var)
    {
        GPBUtil::checkMessage($var, \Google\Protobuf\Duration::class);
        $this->result_end_offset = $var;

        return $this;
    }

    /**
     * Output only. The [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt)
     * language tag of the language in this result. This language code was
     * detected to have the most likelihood of being spoken in the audio.
     *
     * Generated from protobuf field <code>string language_code = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->language_code;
    }

    /**
     * Output only. The [BCP-47](https://www.rfc-editor.org/rfc/bcp/bcp47.txt)
     * language tag of the language in this result. This language code was
     * detected to have the most likelihood of being spoken in the audio.
     *
     * Generated from protobuf field <code>string language_code = 5 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
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

