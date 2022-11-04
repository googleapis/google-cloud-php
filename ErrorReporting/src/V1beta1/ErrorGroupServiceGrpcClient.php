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
 * Service for retrieving and updating individual error groups.
 */
class ErrorGroupServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Get the specified group.
     * @param \Google\Cloud\ErrorReporting\V1beta1\GetGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGroup(\Google\Cloud\ErrorReporting\V1beta1\GetGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouderrorreporting.v1beta1.ErrorGroupService/GetGroup',
        $argument,
        ['\Google\Cloud\ErrorReporting\V1beta1\ErrorGroup', 'decode'],
        $metadata, $options);
    }

    /**
     * Replace the data for the specified group.
     * Fails if the group does not exist.
     * @param \Google\Cloud\ErrorReporting\V1beta1\UpdateGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGroup(\Google\Cloud\ErrorReporting\V1beta1\UpdateGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.devtools.clouderrorreporting.v1beta1.ErrorGroupService/UpdateGroup',
        $argument,
        ['\Google\Cloud\ErrorReporting\V1beta1\ErrorGroup', 'decode'],
        $metadata, $options);
    }

}
