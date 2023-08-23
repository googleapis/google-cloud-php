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
namespace Google\Cloud\Notebooks\V1;

/**
 * API v1 service for Managed Notebooks.
 */
class ManagedNotebookServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Runtimes in a given project and location.
     * @param \Google\Cloud\Notebooks\V1\ListRuntimesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRuntimes(\Google\Cloud\Notebooks\V1\ListRuntimesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/ListRuntimes',
        $argument,
        ['\Google\Cloud\Notebooks\V1\ListRuntimesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Runtime. The location must be a regional endpoint
     * rather than zonal.
     * @param \Google\Cloud\Notebooks\V1\GetRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRuntime(\Google\Cloud\Notebooks\V1\GetRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/GetRuntime',
        $argument,
        ['\Google\Cloud\Notebooks\V1\Runtime', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Runtime in a given project and location.
     * @param \Google\Cloud\Notebooks\V1\CreateRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRuntime(\Google\Cloud\Notebooks\V1\CreateRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/CreateRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update Notebook Runtime configuration.
     * @param \Google\Cloud\Notebooks\V1\UpdateRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRuntime(\Google\Cloud\Notebooks\V1\UpdateRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/UpdateRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Runtime.
     * @param \Google\Cloud\Notebooks\V1\DeleteRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRuntime(\Google\Cloud\Notebooks\V1\DeleteRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/DeleteRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a Managed Notebook Runtime.
     * Perform "Start" on GPU instances; "Resume" on CPU instances
     * See:
     * https://cloud.google.com/compute/docs/instances/stop-start-instance
     * https://cloud.google.com/compute/docs/instances/suspend-resume-instance
     * @param \Google\Cloud\Notebooks\V1\StartRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartRuntime(\Google\Cloud\Notebooks\V1\StartRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/StartRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops a Managed Notebook Runtime.
     * Perform "Stop" on GPU instances; "Suspend" on CPU instances
     * See:
     * https://cloud.google.com/compute/docs/instances/stop-start-instance
     * https://cloud.google.com/compute/docs/instances/suspend-resume-instance
     * @param \Google\Cloud\Notebooks\V1\StopRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopRuntime(\Google\Cloud\Notebooks\V1\StopRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/StopRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Switch a Managed Notebook Runtime.
     * @param \Google\Cloud\Notebooks\V1\SwitchRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SwitchRuntime(\Google\Cloud\Notebooks\V1\SwitchRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/SwitchRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets a Managed Notebook Runtime.
     * @param \Google\Cloud\Notebooks\V1\ResetRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetRuntime(\Google\Cloud\Notebooks\V1\ResetRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/ResetRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Upgrades a Managed Notebook Runtime to the latest version.
     * @param \Google\Cloud\Notebooks\V1\UpgradeRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpgradeRuntime(\Google\Cloud\Notebooks\V1\UpgradeRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/UpgradeRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Report and process a runtime event.
     * @param \Google\Cloud\Notebooks\V1\ReportRuntimeEventRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReportRuntimeEvent(\Google\Cloud\Notebooks\V1\ReportRuntimeEventRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/ReportRuntimeEvent',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an access token for the consumer service account that the customer
     * attached to the runtime. Only accessible from the tenant instance.
     * @param \Google\Cloud\Notebooks\V1\RefreshRuntimeTokenInternalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RefreshRuntimeTokenInternal(\Google\Cloud\Notebooks\V1\RefreshRuntimeTokenInternalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/RefreshRuntimeTokenInternal',
        $argument,
        ['\Google\Cloud\Notebooks\V1\RefreshRuntimeTokenInternalResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Diagnostic File and runs Diagnostic Tool given a Runtime.
     * @param \Google\Cloud\Notebooks\V1\DiagnoseRuntimeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DiagnoseRuntime(\Google\Cloud\Notebooks\V1\DiagnoseRuntimeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.ManagedNotebookService/DiagnoseRuntime',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
