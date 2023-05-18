<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Cloud\AIPlatform\V1;

/**
 * MatchService is a Google managed service for efficient vector similarity
 * search at scale.
 */
class MatchServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Finds the nearest neighbors of each vector within the request.
     * @param \Google\Cloud\AIPlatform\V1\FindNeighborsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FindNeighbors(\Google\Cloud\AIPlatform\V1\FindNeighborsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MatchService/FindNeighbors',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\FindNeighborsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Reads the datapoints/vectors of the given IDs.
     * A maximum of 1000 datapoints can be retrieved in a batch.
     * @param \Google\Cloud\AIPlatform\V1\ReadIndexDatapointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReadIndexDatapoints(\Google\Cloud\AIPlatform\V1\ReadIndexDatapointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.MatchService/ReadIndexDatapoints',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ReadIndexDatapointsResponse', 'decode'],
        $metadata, $options);
    }

}
