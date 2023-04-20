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
namespace Google\Cloud\ResourceManager\V3;

/**
 * Allow users to create and manage TagHolds for TagValues. TagHolds represent
 * the use of a Tag Value that is not captured by TagBindings but
 * should still block TagValue deletion (such as a reference in a policy
 * condition). This service provides isolated failure domains by cloud location
 * so that TagHolds can be managed in the same location as their usage.
 */
class TagHoldsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a TagHold. Returns ALREADY_EXISTS if a TagHold with the same
     * resource and origin exists under the same TagValue.
     * @param \Google\Cloud\ResourceManager\V3\CreateTagHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTagHold(\Google\Cloud\ResourceManager\V3\CreateTagHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagHolds/CreateTagHold',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TagHold.
     * @param \Google\Cloud\ResourceManager\V3\DeleteTagHoldRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTagHold(\Google\Cloud\ResourceManager\V3\DeleteTagHoldRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagHolds/DeleteTagHold',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists TagHolds under a TagValue.
     * @param \Google\Cloud\ResourceManager\V3\ListTagHoldsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTagHolds(\Google\Cloud\ResourceManager\V3\ListTagHoldsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.TagHolds/ListTagHolds',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\ListTagHoldsResponse', 'decode'],
        $metadata, $options);
    }

}
