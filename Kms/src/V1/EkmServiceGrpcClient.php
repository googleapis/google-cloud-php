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
namespace Google\Cloud\Kms\V1;

/**
 * Google Cloud Key Management EKM Service
 *
 * Manages external cryptographic keys and operations using those keys.
 * Implements a REST model with the following objects:
 * * [EkmConnection][google.cloud.kms.v1.EkmConnection]
 */
class EkmServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists [EkmConnections][google.cloud.kms.v1.EkmConnection].
     * @param \Google\Cloud\Kms\V1\ListEkmConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEkmConnections(\Google\Cloud\Kms\V1\ListEkmConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.EkmService/ListEkmConnections',
        $argument,
        ['\Google\Cloud\Kms\V1\ListEkmConnectionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns metadata for a given
     * [EkmConnection][google.cloud.kms.v1.EkmConnection].
     * @param \Google\Cloud\Kms\V1\GetEkmConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEkmConnection(\Google\Cloud\Kms\V1\GetEkmConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.EkmService/GetEkmConnection',
        $argument,
        ['\Google\Cloud\Kms\V1\EkmConnection', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new [EkmConnection][google.cloud.kms.v1.EkmConnection] in a given
     * Project and Location.
     * @param \Google\Cloud\Kms\V1\CreateEkmConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEkmConnection(\Google\Cloud\Kms\V1\CreateEkmConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.EkmService/CreateEkmConnection',
        $argument,
        ['\Google\Cloud\Kms\V1\EkmConnection', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [EkmConnection][google.cloud.kms.v1.EkmConnection]'s metadata.
     * @param \Google\Cloud\Kms\V1\UpdateEkmConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEkmConnection(\Google\Cloud\Kms\V1\UpdateEkmConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.EkmService/UpdateEkmConnection',
        $argument,
        ['\Google\Cloud\Kms\V1\EkmConnection', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the [EkmConfig][google.cloud.kms.v1.EkmConfig] singleton resource
     * for a given project and location.
     * @param \Google\Cloud\Kms\V1\GetEkmConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEkmConfig(\Google\Cloud\Kms\V1\GetEkmConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.EkmService/GetEkmConfig',
        $argument,
        ['\Google\Cloud\Kms\V1\EkmConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the [EkmConfig][google.cloud.kms.v1.EkmConfig] singleton resource
     * for a given project and location.
     * @param \Google\Cloud\Kms\V1\UpdateEkmConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEkmConfig(\Google\Cloud\Kms\V1\UpdateEkmConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.EkmService/UpdateEkmConfig',
        $argument,
        ['\Google\Cloud\Kms\V1\EkmConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Verifies that Cloud KMS can successfully connect to the external key
     * manager specified by an [EkmConnection][google.cloud.kms.v1.EkmConnection].
     * If there is an error connecting to the EKM, this method returns a
     * FAILED_PRECONDITION status containing structured information as described
     * at https://cloud.google.com/kms/docs/reference/ekm_errors.
     * @param \Google\Cloud\Kms\V1\VerifyConnectivityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function VerifyConnectivity(\Google\Cloud\Kms\V1\VerifyConnectivityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.EkmService/VerifyConnectivity',
        $argument,
        ['\Google\Cloud\Kms\V1\VerifyConnectivityResponse', 'decode'],
        $metadata, $options);
    }

}
