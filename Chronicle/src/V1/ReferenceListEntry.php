<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/chronicle/v1/reference_list.proto

namespace Google\Cloud\Chronicle\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * An entry in a reference list.
 *
 * Generated from protobuf message <code>google.cloud.chronicle.v1.ReferenceListEntry</code>
 */
class ReferenceListEntry extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The value of the entry. Maximum length is 512 characters.
     *
     * Generated from protobuf field <code>string value = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $value = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $value
     *           Required. The value of the entry. Maximum length is 512 characters.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Chronicle\V1\ReferenceList::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The value of the entry. Maximum length is 512 characters.
     *
     * Generated from protobuf field <code>string value = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Required. The value of the entry. Maximum length is 512 characters.
     *
     * Generated from protobuf field <code>string value = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setValue($var)
    {
        GPBUtil::checkString($var, True);
        $this->value = $var;

        return $this;
    }

}

