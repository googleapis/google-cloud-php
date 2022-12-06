<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\ApigeeRegistry\V1;

/**
 * The service that is used for managing the data plane provisioning of the
 * Registry.
 */
class ProvisioningGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Provisions instance resources for the Registry.
     * @param \Google\Cloud\ApigeeRegistry\V1\CreateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateInstance(\Google\Cloud\ApigeeRegistry\V1\CreateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Provisioning/CreateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the Registry instance.
     * @param \Google\Cloud\ApigeeRegistry\V1\DeleteInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInstance(\Google\Cloud\ApigeeRegistry\V1\DeleteInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Provisioning/DeleteInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Instance.
     * @param \Google\Cloud\ApigeeRegistry\V1\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\ApigeeRegistry\V1\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigeeregistry.v1.Provisioning/GetInstance',
        $argument,
        ['\Google\Cloud\ApigeeRegistry\V1\Instance', 'decode'],
        $metadata, $options);
    }

}
