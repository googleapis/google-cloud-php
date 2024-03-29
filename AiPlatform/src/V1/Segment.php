<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/content.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Segment of the content.
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.Segment</code>
 */
class Segment extends \Google\Protobuf\Internal\Message
{
    /**
     * Output only. The index of a Part object within its parent Content object.
     *
     * Generated from protobuf field <code>int32 part_index = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $part_index = 0;
    /**
     * Output only. Start index in the given Part, measured in bytes. Offset from
     * the start of the Part, inclusive, starting at zero.
     *
     * Generated from protobuf field <code>int32 start_index = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $start_index = 0;
    /**
     * Output only. End index in the given Part, measured in bytes. Offset from
     * the start of the Part, exclusive, starting at zero.
     *
     * Generated from protobuf field <code>int32 end_index = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     */
    private $end_index = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int $part_index
     *           Output only. The index of a Part object within its parent Content object.
     *     @type int $start_index
     *           Output only. Start index in the given Part, measured in bytes. Offset from
     *           the start of the Part, inclusive, starting at zero.
     *     @type int $end_index
     *           Output only. End index in the given Part, measured in bytes. Offset from
     *           the start of the Part, exclusive, starting at zero.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\Content::initOnce();
        parent::__construct($data);
    }

    /**
     * Output only. The index of a Part object within its parent Content object.
     *
     * Generated from protobuf field <code>int32 part_index = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getPartIndex()
    {
        return $this->part_index;
    }

    /**
     * Output only. The index of a Part object within its parent Content object.
     *
     * Generated from protobuf field <code>int32 part_index = 1 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setPartIndex($var)
    {
        GPBUtil::checkInt32($var);
        $this->part_index = $var;

        return $this;
    }

    /**
     * Output only. Start index in the given Part, measured in bytes. Offset from
     * the start of the Part, inclusive, starting at zero.
     *
     * Generated from protobuf field <code>int32 start_index = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getStartIndex()
    {
        return $this->start_index;
    }

    /**
     * Output only. Start index in the given Part, measured in bytes. Offset from
     * the start of the Part, inclusive, starting at zero.
     *
     * Generated from protobuf field <code>int32 start_index = 2 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setStartIndex($var)
    {
        GPBUtil::checkInt32($var);
        $this->start_index = $var;

        return $this;
    }

    /**
     * Output only. End index in the given Part, measured in bytes. Offset from
     * the start of the Part, exclusive, starting at zero.
     *
     * Generated from protobuf field <code>int32 end_index = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @return int
     */
    public function getEndIndex()
    {
        return $this->end_index;
    }

    /**
     * Output only. End index in the given Part, measured in bytes. Offset from
     * the start of the Part, exclusive, starting at zero.
     *
     * Generated from protobuf field <code>int32 end_index = 3 [(.google.api.field_behavior) = OUTPUT_ONLY];</code>
     * @param int $var
     * @return $this
     */
    public function setEndIndex($var)
    {
        GPBUtil::checkInt32($var);
        $this->end_index = $var;

        return $this;
    }

}

