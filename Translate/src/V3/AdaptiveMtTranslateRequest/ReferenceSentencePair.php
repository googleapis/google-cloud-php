<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/translate/v3/adaptive_mt.proto

namespace Google\Cloud\Translate\V3\AdaptiveMtTranslateRequest;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A pair of sentences used as reference in source and target languages.
 *
 * Generated from protobuf message <code>google.cloud.translation.v3.AdaptiveMtTranslateRequest.ReferenceSentencePair</code>
 */
class ReferenceSentencePair extends \Google\Protobuf\Internal\Message
{
    /**
     * Source sentence in the sentence pair.
     *
     * Generated from protobuf field <code>string source_sentence = 1;</code>
     */
    protected $source_sentence = '';
    /**
     * Target sentence in the sentence pair.
     *
     * Generated from protobuf field <code>string target_sentence = 2;</code>
     */
    protected $target_sentence = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $source_sentence
     *           Source sentence in the sentence pair.
     *     @type string $target_sentence
     *           Target sentence in the sentence pair.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Translate\V3\AdaptiveMt::initOnce();
        parent::__construct($data);
    }

    /**
     * Source sentence in the sentence pair.
     *
     * Generated from protobuf field <code>string source_sentence = 1;</code>
     * @return string
     */
    public function getSourceSentence()
    {
        return $this->source_sentence;
    }

    /**
     * Source sentence in the sentence pair.
     *
     * Generated from protobuf field <code>string source_sentence = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setSourceSentence($var)
    {
        GPBUtil::checkString($var, True);
        $this->source_sentence = $var;

        return $this;
    }

    /**
     * Target sentence in the sentence pair.
     *
     * Generated from protobuf field <code>string target_sentence = 2;</code>
     * @return string
     */
    public function getTargetSentence()
    {
        return $this->target_sentence;
    }

    /**
     * Target sentence in the sentence pair.
     *
     * Generated from protobuf field <code>string target_sentence = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setTargetSentence($var)
    {
        GPBUtil::checkString($var, True);
        $this->target_sentence = $var;

        return $this;
    }

}


