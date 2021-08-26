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
namespace Google\Cloud\Eventarc\V1;

/**
 * Eventarc allows users to subscribe to various events that are provided by
 * Google Cloud services and forward them to supported destinations.
 */
class EventarcGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Get a single trigger.
     * @param \Google\Cloud\Eventarc\V1\GetTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTrigger(\Google\Cloud\Eventarc\V1\GetTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/GetTrigger',
        $argument,
        ['\Google\Cloud\Eventarc\V1\Trigger', 'decode'],
        $metadata, $options);
    }

    /**
     * List triggers.
     * @param \Google\Cloud\Eventarc\V1\ListTriggersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTriggers(\Google\Cloud\Eventarc\V1\ListTriggersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/ListTriggers',
        $argument,
        ['\Google\Cloud\Eventarc\V1\ListTriggersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new trigger in a particular project and location.
     * @param \Google\Cloud\Eventarc\V1\CreateTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTrigger(\Google\Cloud\Eventarc\V1\CreateTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/CreateTrigger',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a single trigger.
     * @param \Google\Cloud\Eventarc\V1\UpdateTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTrigger(\Google\Cloud\Eventarc\V1\UpdateTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/UpdateTrigger',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a single trigger.
     * @param \Google\Cloud\Eventarc\V1\DeleteTriggerRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTrigger(\Google\Cloud\Eventarc\V1\DeleteTriggerRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.eventarc.v1.Eventarc/DeleteTrigger',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
