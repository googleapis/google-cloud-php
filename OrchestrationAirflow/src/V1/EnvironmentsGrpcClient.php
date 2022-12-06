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
namespace Google\Cloud\Orchestration\Airflow\Service\V1;

/**
 * Managed Apache Airflow Environments.
 */
class EnvironmentsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a new environment.
     * @param \Google\Cloud\Orchestration\Airflow\Service\V1\CreateEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEnvironment(\Google\Cloud\Orchestration\Airflow\Service\V1\CreateEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orchestration.airflow.service.v1.Environments/CreateEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Get an existing environment.
     * @param \Google\Cloud\Orchestration\Airflow\Service\V1\GetEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEnvironment(\Google\Cloud\Orchestration\Airflow\Service\V1\GetEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orchestration.airflow.service.v1.Environments/GetEnvironment',
        $argument,
        ['\Google\Cloud\Orchestration\Airflow\Service\V1\Environment', 'decode'],
        $metadata, $options);
    }

    /**
     * List environments.
     * @param \Google\Cloud\Orchestration\Airflow\Service\V1\ListEnvironmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEnvironments(\Google\Cloud\Orchestration\Airflow\Service\V1\ListEnvironmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orchestration.airflow.service.v1.Environments/ListEnvironments',
        $argument,
        ['\Google\Cloud\Orchestration\Airflow\Service\V1\ListEnvironmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update an environment.
     * @param \Google\Cloud\Orchestration\Airflow\Service\V1\UpdateEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEnvironment(\Google\Cloud\Orchestration\Airflow\Service\V1\UpdateEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orchestration.airflow.service.v1.Environments/UpdateEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an environment.
     * @param \Google\Cloud\Orchestration\Airflow\Service\V1\DeleteEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEnvironment(\Google\Cloud\Orchestration\Airflow\Service\V1\DeleteEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orchestration.airflow.service.v1.Environments/DeleteEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a snapshots of a Cloud Composer environment.
     *
     * As a result of this operation, snapshot of environment's state is stored
     * in a location specified in the SaveSnapshotRequest.
     * @param \Google\Cloud\Orchestration\Airflow\Service\V1\SaveSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SaveSnapshot(\Google\Cloud\Orchestration\Airflow\Service\V1\SaveSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orchestration.airflow.service.v1.Environments/SaveSnapshot',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Loads a snapshot of a Cloud Composer environment.
     *
     * As a result of this operation, a snapshot of environment's specified in
     * LoadSnapshotRequest is loaded into the environment.
     * @param \Google\Cloud\Orchestration\Airflow\Service\V1\LoadSnapshotRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LoadSnapshot(\Google\Cloud\Orchestration\Airflow\Service\V1\LoadSnapshotRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orchestration.airflow.service.v1.Environments/LoadSnapshot',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
