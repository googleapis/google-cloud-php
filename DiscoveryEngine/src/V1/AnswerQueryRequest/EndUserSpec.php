<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/discoveryengine/v1/conversational_search_service.proto

namespace Google\Cloud\DiscoveryEngine\V1\AnswerQueryRequest;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * End user specification.
 *
 * Generated from protobuf message <code>google.cloud.discoveryengine.v1.AnswerQueryRequest.EndUserSpec</code>
 */
class EndUserSpec extends \Google\Protobuf\Internal\Message
{
    /**
     * Optional. End user metadata.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.AnswerQueryRequest.EndUserSpec.EndUserMetaData end_user_metadata = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     */
    private $end_user_metadata;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\DiscoveryEngine\V1\AnswerQueryRequest\EndUserSpec\EndUserMetaData>|\Google\Protobuf\Internal\RepeatedField $end_user_metadata
     *           Optional. End user metadata.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Discoveryengine\V1\ConversationalSearchService::initOnce();
        parent::__construct($data);
    }

    /**
     * Optional. End user metadata.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.AnswerQueryRequest.EndUserSpec.EndUserMetaData end_user_metadata = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getEndUserMetadata()
    {
        return $this->end_user_metadata;
    }

    /**
     * Optional. End user metadata.
     *
     * Generated from protobuf field <code>repeated .google.cloud.discoveryengine.v1.AnswerQueryRequest.EndUserSpec.EndUserMetaData end_user_metadata = 1 [(.google.api.field_behavior) = OPTIONAL];</code>
     * @param array<\Google\Cloud\DiscoveryEngine\V1\AnswerQueryRequest\EndUserSpec\EndUserMetaData>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setEndUserMetadata($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\DiscoveryEngine\V1\AnswerQueryRequest\EndUserSpec\EndUserMetaData::class);
        $this->end_user_metadata = $arr;

        return $this;
    }

}


