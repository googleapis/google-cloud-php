<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/cloud/recommender/v1/insight.proto

namespace Google\Cloud\Recommender\V1\Insight;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Reference to an associated recommendation.
 *
 * Generated from protobuf message <code>google.cloud.recommender.v1.Insight.RecommendationReference</code>
 */
class RecommendationReference extends \Google\Protobuf\Internal\Message
{
    /**
     * Recommendation resource name, e.g.
     * projects/[PROJECT_NUMBER]/locations/[LOCATION]/recommenders/[RECOMMENDER_ID]/recommendations/[RECOMMENDATION_ID]
     *
     * Generated from protobuf field <code>string recommendation = 1;</code>
     */
    protected $recommendation = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $recommendation
     *           Recommendation resource name, e.g.
     *           projects/[PROJECT_NUMBER]/locations/[LOCATION]/recommenders/[RECOMMENDER_ID]/recommendations/[RECOMMENDATION_ID]
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Cloud\Recommender\V1\Insight::initOnce();
        parent::__construct($data);
    }

    /**
     * Recommendation resource name, e.g.
     * projects/[PROJECT_NUMBER]/locations/[LOCATION]/recommenders/[RECOMMENDER_ID]/recommendations/[RECOMMENDATION_ID]
     *
     * Generated from protobuf field <code>string recommendation = 1;</code>
     * @return string
     */
    public function getRecommendation()
    {
        return $this->recommendation;
    }

    /**
     * Recommendation resource name, e.g.
     * projects/[PROJECT_NUMBER]/locations/[LOCATION]/recommenders/[RECOMMENDER_ID]/recommendations/[RECOMMENDATION_ID]
     *
     * Generated from protobuf field <code>string recommendation = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setRecommendation($var)
    {
        GPBUtil::checkString($var, True);
        $this->recommendation = $var;

        return $this;
    }

}


