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
namespace Google\Cloud\RecommendationEngine\V1beta1;

/**
 * Service for ingesting end user actions on the customer website.
 */
class UserEventServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Writes a single user event.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\WriteUserEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function WriteUserEvent(\Google\Cloud\RecommendationEngine\V1beta1\WriteUserEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.UserEventService/WriteUserEvent',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\UserEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Writes a single user event from the browser. This uses a GET request to
     * due to browser restriction of POST-ing to a 3rd party domain.
     *
     * This method is used only by the Recommendations AI JavaScript pixel.
     * Users should not call this method directly.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\CollectUserEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CollectUserEvent(\Google\Cloud\RecommendationEngine\V1beta1\CollectUserEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.UserEventService/CollectUserEvent',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a list of user events within a time range, with potential filtering.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\ListUserEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListUserEvents(\Google\Cloud\RecommendationEngine\V1beta1\ListUserEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.UserEventService/ListUserEvents',
        $argument,
        ['\Google\Cloud\RecommendationEngine\V1beta1\ListUserEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes permanently all user events specified by the filter provided.
     * Depending on the number of events specified by the filter, this operation
     * could take hours or days to complete. To test a filter, use the list
     * command first.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\PurgeUserEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PurgeUserEvents(\Google\Cloud\RecommendationEngine\V1beta1\PurgeUserEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.UserEventService/PurgeUserEvents',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Bulk import of User events. Request processing might be
     * synchronous. Events that already exist are skipped.
     * Use this method for backfilling historical user events.
     *
     * Operation.response is of type ImportResponse. Note that it is
     * possible for a subset of the items to be successfully inserted.
     * Operation.metadata is of type ImportMetadata.
     * @param \Google\Cloud\RecommendationEngine\V1beta1\ImportUserEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportUserEvents(\Google\Cloud\RecommendationEngine\V1beta1\ImportUserEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.recommendationengine.v1beta1.UserEventService/ImportUserEvents',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
