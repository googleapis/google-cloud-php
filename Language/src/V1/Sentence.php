<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/language/v1/language_service.proto

namespace Google\Cloud\Language\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Represents a sentence in the input document.
 *
 * Generated from protobuf message <code>google.cloud.language.v1.Sentence</code>
 */
class Sentence extends \Google\Protobuf\Internal\Message
{
    /**
     * The sentence text.
     *
     * Generated from protobuf field <code>.google.cloud.language.v1.TextSpan text = 1;</code>
     */
    protected $text = null;
    /**
     * For calls to [AnalyzeSentiment][] or if
     * [AnnotateTextRequest.Features.extract_document_sentiment][google.cloud.language.v1.AnnotateTextRequest.Features.extract_document_sentiment]
     * is set to true, this field will contain the sentiment for the sentence.
     *
     * Generated from protobuf field <code>.google.cloud.language.v1.Sentiment sentiment = 2;</code>
     */
    protected $sentiment = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Google\Cloud\Language\V1\TextSpan $text
     *           The sentence text.
     *     @type \Google\Cloud\Language\V1\Sentiment $sentiment
     *           For calls to [AnalyzeSentiment][] or if
     *           [AnnotateTextRequest.Features.extract_document_sentiment][google.cloud.language.v1.AnnotateTextRequest.Features.extract_document_sentiment]
     *           is set to true, this field will contain the sentiment for the sentence.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Language\V1\LanguageService::initOnce();
        parent::__construct($data);
    }

    /**
     * The sentence text.
     *
     * Generated from protobuf field <code>.google.cloud.language.v1.TextSpan text = 1;</code>
     * @return \Google\Cloud\Language\V1\TextSpan|null
     */
    public function getText()
    {
        return $this->text;
    }

    public function hasText()
    {
        return isset($this->text);
    }

    public function clearText()
    {
        unset($this->text);
    }

    /**
     * The sentence text.
     *
     * Generated from protobuf field <code>.google.cloud.language.v1.TextSpan text = 1;</code>
     * @param \Google\Cloud\Language\V1\TextSpan $var
     * @return $this
     */
    public function setText($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Language\V1\TextSpan::class);
        $this->text = $var;

        return $this;
    }

    /**
     * For calls to [AnalyzeSentiment][] or if
     * [AnnotateTextRequest.Features.extract_document_sentiment][google.cloud.language.v1.AnnotateTextRequest.Features.extract_document_sentiment]
     * is set to true, this field will contain the sentiment for the sentence.
     *
     * Generated from protobuf field <code>.google.cloud.language.v1.Sentiment sentiment = 2;</code>
     * @return \Google\Cloud\Language\V1\Sentiment|null
     */
    public function getSentiment()
    {
        return $this->sentiment;
    }

    public function hasSentiment()
    {
        return isset($this->sentiment);
    }

    public function clearSentiment()
    {
        unset($this->sentiment);
    }

    /**
     * For calls to [AnalyzeSentiment][] or if
     * [AnnotateTextRequest.Features.extract_document_sentiment][google.cloud.language.v1.AnnotateTextRequest.Features.extract_document_sentiment]
     * is set to true, this field will contain the sentiment for the sentence.
     *
     * Generated from protobuf field <code>.google.cloud.language.v1.Sentiment sentiment = 2;</code>
     * @param \Google\Cloud\Language\V1\Sentiment $var
     * @return $this
     */
    public function setSentiment($var)
    {
        GPBUtil::checkMessage($var, \Google\Cloud\Language\V1\Sentiment::class);
        $this->sentiment = $var;

        return $this;
    }

}

