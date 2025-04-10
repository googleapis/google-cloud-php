<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/answer.proto

namespace Google\Cloud\DiscoveryEngine\V1\Answer;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Citation info for a segment.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.Answer.Citation</code>
 */
class Citation extends \Google\Protobuf\Internal\Message
{
    /**
     * Index indicates the start of the segment, measured in bytes (UTF-8
     * unicode). If there are multi-byte characters,such as non-ASCII
     * characters, the index measurement is longer than the string length.
     *
     * Generated from protobuf field <code>int64 start_index = 1;</code>
     */
    protected $start_index = 0;
    /**
     * End of the attributed segment, exclusive. Measured in bytes (UTF-8
     * unicode). If there are multi-byte characters,such as non-ASCII
     * characters, the index measurement is longer than the string length.
     *
     * Generated from protobuf field <code>int64 end_index = 2;</code>
     */
    protected $end_index = 0;
    /**
     * Citation sources for the attributed segment.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Answer.CitationSource sources = 3;</code>
     */
    private $sources;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $start_index
     *           Index indicates the start of the segment, measured in bytes (UTF-8
     *           unicode). If there are multi-byte characters,such as non-ASCII
     *           characters, the index measurement is longer than the string length.
     *     @type int|string $end_index
     *           End of the attributed segment, exclusive. Measured in bytes (UTF-8
     *           unicode). If there are multi-byte characters,such as non-ASCII
     *           characters, the index measurement is longer than the string length.
     *     @type array<\Google\Cloud\DiscoveryEngine\V1\Answer\CitationSource>|\Google\Protobuf\Internal\RepeatedField $sources
     *           Citation sources for the attributed segment.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\Answer::initOnce();
        parent::__construct($data);
    }

    /**
     * Index indicates the start of the segment, measured in bytes (UTF-8
     * unicode). If there are multi-byte characters,such as non-ASCII
     * characters, the index measurement is longer than the string length.
     *
     * Generated from protobuf field <code>int64 start_index = 1;</code>
     * @return int|string
     */
    public function getStartIndex()
    {
        return $this->start_index;
    }

    /**
     * Index indicates the start of the segment, measured in bytes (UTF-8
     * unicode). If there are multi-byte characters,such as non-ASCII
     * characters, the index measurement is longer than the string length.
     *
     * Generated from protobuf field <code>int64 start_index = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setStartIndex($var)
    {
        GPBUtil::checkInt64($var);
        $this->start_index = $var;

        return $this;
    }

    /**
     * End of the attributed segment, exclusive. Measured in bytes (UTF-8
     * unicode). If there are multi-byte characters,such as non-ASCII
     * characters, the index measurement is longer than the string length.
     *
     * Generated from protobuf field <code>int64 end_index = 2;</code>
     * @return int|string
     */
    public function getEndIndex()
    {
        return $this->end_index;
    }

    /**
     * End of the attributed segment, exclusive. Measured in bytes (UTF-8
     * unicode). If there are multi-byte characters,such as non-ASCII
     * characters, the index measurement is longer than the string length.
     *
     * Generated from protobuf field <code>int64 end_index = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setEndIndex($var)
    {
        GPBUtil::checkInt64($var);
        $this->end_index = $var;

        return $this;
    }

    /**
     * Citation sources for the attributed segment.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Answer.CitationSource sources = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getSources()
    {
        return $this->sources;
    }

    /**
     * Citation sources for the attributed segment.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.Answer.CitationSource sources = 3;</code>
     * @param array<\Google\Cloud\DiscoveryEngine\V1\Answer\CitationSource>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setSources($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\DiscoveryEngine\V1\Answer\CitationSource::class);
        $this->sources = $arr;

        return $this;
    }

}


