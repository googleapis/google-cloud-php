<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
namespace Google\Cloud\Recommender\V1;

/**
 * Provides insights and recommendations for cloud customers for various
 * categories like performance optimization, cost savings, reliability, feature
 * discovery, etc. Insights and recommendations are generated automatically
 * based on analysis of user resources, configuration and monitoring metrics.
 */
class RecommenderGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists insights for a Cloud project. Requires the recommender.*.list IAM
     * permission for the specified insight type.
     * @param \Google\Cloud\Recommender\V1\ListInsightsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInsights(\Google\Cloud\Recommender\V1\ListInsightsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/ListInsights',
        $argument,
        ['\Google\Cloud\Recommender\V1\ListInsightsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the requested insight. Requires the recommender.*.get IAM permission
     * for the specified insight type.
     * @param \Google\Cloud\Recommender\V1\GetInsightRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInsight(\Google\Cloud\Recommender\V1\GetInsightRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/GetInsight',
        $argument,
        ['\Google\Cloud\Recommender\V1\Insight', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks the Insight State as Accepted. Users can use this method to
     * indicate to the Recommender API that they have applied some action based
     * on the insight. This stops the insight content from being updated.
     *
     * MarkInsightAccepted can be applied to insights in ACTIVE state. Requires
     * the recommender.*.update IAM permission for the specified insight.
     * @param \Google\Cloud\Recommender\V1\MarkInsightAcceptedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MarkInsightAccepted(\Google\Cloud\Recommender\V1\MarkInsightAcceptedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/MarkInsightAccepted',
        $argument,
        ['\Google\Cloud\Recommender\V1\Insight', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists recommendations for a Cloud project. Requires the recommender.*.list
     * IAM permission for the specified recommender.
     * @param \Google\Cloud\Recommender\V1\ListRecommendationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRecommendations(\Google\Cloud\Recommender\V1\ListRecommendationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/ListRecommendations',
        $argument,
        ['\Google\Cloud\Recommender\V1\ListRecommendationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the requested recommendation. Requires the recommender.*.get
     * IAM permission for the specified recommender.
     * @param \Google\Cloud\Recommender\V1\GetRecommendationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRecommendation(\Google\Cloud\Recommender\V1\GetRecommendationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/GetRecommendation',
        $argument,
        ['\Google\Cloud\Recommender\V1\Recommendation', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks the Recommendation State as Claimed. Users can use this method to
     * indicate to the Recommender API that they are starting to apply the
     * recommendation themselves. This stops the recommendation content from being
     * updated. Associated insights are frozen and placed in the ACCEPTED state.
     *
     * MarkRecommendationClaimed can be applied to recommendations in CLAIMED,
     * SUCCEEDED, FAILED, or ACTIVE state.
     *
     * Requires the recommender.*.update IAM permission for the specified
     * recommender.
     * @param \Google\Cloud\Recommender\V1\MarkRecommendationClaimedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MarkRecommendationClaimed(\Google\Cloud\Recommender\V1\MarkRecommendationClaimedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/MarkRecommendationClaimed',
        $argument,
        ['\Google\Cloud\Recommender\V1\Recommendation', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks the Recommendation State as Succeeded. Users can use this method to
     * indicate to the Recommender API that they have applied the recommendation
     * themselves, and the operation was successful. This stops the recommendation
     * content from being updated. Associated insights are frozen and placed in
     * the ACCEPTED state.
     *
     * MarkRecommendationSucceeded can be applied to recommendations in ACTIVE,
     * CLAIMED, SUCCEEDED, or FAILED state.
     *
     * Requires the recommender.*.update IAM permission for the specified
     * recommender.
     * @param \Google\Cloud\Recommender\V1\MarkRecommendationSucceededRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MarkRecommendationSucceeded(\Google\Cloud\Recommender\V1\MarkRecommendationSucceededRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/MarkRecommendationSucceeded',
        $argument,
        ['\Google\Cloud\Recommender\V1\Recommendation', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks the Recommendation State as Failed. Users can use this method to
     * indicate to the Recommender API that they have applied the recommendation
     * themselves, and the operation failed. This stops the recommendation content
     * from being updated. Associated insights are frozen and placed in the
     * ACCEPTED state.
     *
     * MarkRecommendationFailed can be applied to recommendations in ACTIVE,
     * CLAIMED, SUCCEEDED, or FAILED state.
     *
     * Requires the recommender.*.update IAM permission for the specified
     * recommender.
     * @param \Google\Cloud\Recommender\V1\MarkRecommendationFailedRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MarkRecommendationFailed(\Google\Cloud\Recommender\V1\MarkRecommendationFailedRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommender.v1.Recommender/MarkRecommendationFailed',
        $argument,
        ['\Google\Cloud\Recommender\V1\Recommendation', 'decode'],
        $metadata, $options);
    }

}
