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
namespace Google\Cloud\ErrorReporting\V1beta1;

/**
 * An API for retrieving and managing error statistics as well as data for
 * individual events.
 */
class ErrorStatsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the specified groups.
     * @param \Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGroupStats(\Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouderrorreporting.v1beta1.ErrorStatsService/ListGroupStats',
        $argument,
        ['\Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the specified events.
     * @param \Google\Cloud\ErrorReporting\V1beta1\ListEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEvents(\Google\Cloud\ErrorReporting\V1beta1\ListEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouderrorreporting.v1beta1.ErrorStatsService/ListEvents',
        $argument,
        ['\Google\Cloud\ErrorReporting\V1beta1\ListEventsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes all error events of a given project.
     * @param \Google\Cloud\ErrorReporting\V1beta1\DeleteEventsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEvents(\Google\Cloud\ErrorReporting\V1beta1\DeleteEventsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouderrorreporting.v1beta1.ErrorStatsService/DeleteEvents',
        $argument,
        ['\Google\Cloud\ErrorReporting\V1beta1\DeleteEventsResponse', 'decode'],
        $metadata, $options);
    }

}
