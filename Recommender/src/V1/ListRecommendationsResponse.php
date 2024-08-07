<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/recommender/v1/recommender_service.proto

namespace Google\Cloud\Recommender\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Response to the `ListRecommendations` method.
 *
 * Generated from protobuf message <code>google.cloud.recommender.v1.ListRecommendationsResponse</code>
 */
class ListRecommendationsResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * The set of recommendations for the `parent` resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.recommender.v1.Recommendation recommendations = 1;</code>
     */
    private $recommendations;
    /**
     * A token that can be used to request the next page of results. This field is
     * empty if there are no additional results.
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
     *     @type array<\Google\Cloud\Recommender\V1\Recommendation>|\Google\Protobuf\Internal\RepeatedField $recommendations
     *           The set of recommendations for the `parent` resource.
     *     @type string $next_page_token
     *           A token that can be used to request the next page of results. This field is
     *           empty if there are no additional results.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Recommender\V1\RecommenderService::initOnce();
        parent::__construct($data);
    }

    /**
     * The set of recommendations for the `parent` resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.recommender.v1.Recommendation recommendations = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getRecommendations()
    {
        return $this->recommendations;
    }

    /**
     * The set of recommendations for the `parent` resource.
     *
     * Generated from protobuf field <code>repeated .google.cloud.recommender.v1.Recommendation recommendations = 1;</code>
     * @param array<\Google\Cloud\Recommender\V1\Recommendation>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setRecommendations($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Google\Cloud\Recommender\V1\Recommendation::class);
        $this->recommendations = $arr;

        return $this;
    }

    /**
     * A token that can be used to request the next page of results. This field is
     * empty if there are no additional results.
     *
     * Generated from protobuf field <code>string next_page_token = 2;</code>
     * @return string
     */
    public function getNextPageToken()
    {
        return $this->next_page_token;
    }

    /**
     * A token that can be used to request the next page of results. This field is
     * empty if there are no additional results.
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

