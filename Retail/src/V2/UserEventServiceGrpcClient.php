<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
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
namespace Google\Cloud\Retail\V2;

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
     * @param \Google\Cloud\Retail\V2\WriteUserEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function WriteUserEvent(\Google\Cloud\Retail\V2\WriteUserEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.UserEventService/WriteUserEvent',
        $argument,
        ['\Google\Cloud\Retail\V2\UserEvent', 'decode'],
        $metadata, $options);
    }

    /**
     * Writes a single user event from the browser. This uses a GET request to
     * due to browser restriction of POST-ing to a 3rd party domain.
     *
     * This method is used only by the Retail API JavaScript pixel and Google Tag
     * Manager. Users should not call this method directly.
     * @param \Google\Cloud\Retail\V2\CollectUserEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CollectUserEvent(\Google\Cloud\Retail\V2\CollectUserEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.UserEventService/CollectUserEvent',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes permanently all user events specified by the filter provided.
     * Depending on the number of events specified by the filter, this operation
     * could take hours or days to complete. To test a filter, use the list
     * command first.
     * @param \Google\Cloud\Retail\V2\PurgeUserEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PurgeUserEvents(\Google\Cloud\Retail\V2\PurgeUserEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.UserEventService/PurgeUserEvents',
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
     * @param \Google\Cloud\Retail\V2\ImportUserEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportUserEvents(\Google\Cloud\Retail\V2\ImportUserEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.UserEventService/ImportUserEvents',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a user event rejoin operation with latest product catalog. Events
     * will not be annotated with detailed product information if product is
     * missing from the catalog at the time the user event is ingested, and these
     * events are stored as unjoined events with a limited usage on training and
     * serving. This method can be used to start a join operation on specified
     * events with latest version of product catalog. It can also be used to
     * correct events joined with the wrong product catalog. A rejoin operation
     * can take hours or days to complete.
     * @param \Google\Cloud\Retail\V2\RejoinUserEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RejoinUserEvents(\Google\Cloud\Retail\V2\RejoinUserEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.UserEventService/RejoinUserEvents',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
