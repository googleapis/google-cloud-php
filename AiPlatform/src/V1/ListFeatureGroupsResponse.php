<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/aiplatform/v1/feature_registry_service.proto

namespace Google\Cloud\AIPlatform\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response message for
 * [FeatureRegistryService.ListFeatureGroups][google.cloud.aiplatform.v1.FeatureRegistryService.ListFeatureGroups].
 *
 * Generated from protobuf message <code>google.cloud.aiplatform.v1.ListFeatureGroupsResponse</code>
 */
class ListFeatureGroupsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The FeatureGroups matching the request.
     *
     * Generated from protobuf field <code>repeated .google.cloud.aiplatform.v1.FeatureGroup feature_groups = 1;</code>
     */
    private $feature_groups;
    /**
     * A token, which can be sent as
     * [ListFeatureGroupsRequest.page_token][google.cloud.aiplatform.v1.ListFeatureGroupsRequest.page_token]
     * to retrieve the next page. If this field is omitted, there are no
     * subsequent pages.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     */
    private $next_page_token = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Google\Cloud\AIPlatform\V1\FeatureGroup>|\Google\Protobuf\Internal\RepeatedField $feature_groups
     *           The FeatureGroups matching the request.
     *     @type string $next_page_token
     *           A token, which can be sent as
     *           [ListFeatureGroupsRequest.page_token][google.cloud.aiplatform.v1.ListFeatureGroupsRequest.page_token]
     *           to retrieve the next page. If this field is omitted, there are no
     *           subsequent pages.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Aiplatform\V1\FeatureRegistryService::initOnce();
        parent::__construct($data);
    }

    /**
     * The FeatureGroups matching the request.
     *
     * Generated from protobuf field <code>repeated .google.cloud.aiplatform.v1.FeatureGroup feature_groups = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getFeatureGroups()
    {
        return $this->feature_groups;
    }

    /**
     * The FeatureGroups matching the request.
     *
     * Generated from protobuf field <code>repeated .google.cloud.aiplatform.v1.FeatureGroup feature_groups = 1;</code>
     * @param array<\Google\Cloud\AIPlatform\V1\FeatureGroup>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setFeatureGroups($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\AIPlatform\V1\FeatureGroup::class);
        $this->feature_groups = $arr;

        return $this;
    }

    /**
     * A token, which can be sent as
     * [ListFeatureGroupsRequest.page_token][google.cloud.aiplatform.v1.ListFeatureGroupsRequest.page_token]
     * to retrieve the next page. If this field is omitted, there are no
     * subsequent pages.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * A token, which can be sent as
     * [ListFeatureGroupsRequest.page_token][google.cloud.aiplatform.v1.ListFeatureGroupsRequest.page_token]
     * to retrieve the next page. If this field is omitted, there are no
     * subsequent pages.
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
