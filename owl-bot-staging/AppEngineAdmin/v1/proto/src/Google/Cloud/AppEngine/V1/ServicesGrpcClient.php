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
namespace Google\Cloud\AppEngine\V1;

/**
 * Manages services of an application.
 */
class ServicesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all the services in the application.
     * @param \Google\Cloud\AppEngine\V1\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\AppEngine\V1\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Services/ListServices',
        $argument,
        ['\Google\Cloud\AppEngine\V1\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the current configuration of the specified service.
     * @param \Google\Cloud\AppEngine\V1\GetServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetService(\Google\Cloud\AppEngine\V1\GetServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Services/GetService',
        $argument,
        ['\Google\Cloud\AppEngine\V1\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the configuration of the specified service.
     * @param \Google\Cloud\AppEngine\V1\UpdateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateService(\Google\Cloud\AppEngine\V1\UpdateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Services/UpdateService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified service and all enclosed versions.
     * @param \Google\Cloud\AppEngine\V1\DeleteServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteService(\Google\Cloud\AppEngine\V1\DeleteServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.appengine.v1.Services/DeleteService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
