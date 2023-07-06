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
 * API v1 service for Cloud AI Platform Notebooks.
 */
class NotebookServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists instances in a given project and location.
     * @param \Google\Cloud\Notebooks\V1\ListInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstances(\Google\Cloud\Notebooks\V1\ListInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/ListInstances',
        $argument,
        ['\Google\Cloud\Notebooks\V1\ListInstancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Instance.
     * @param \Google\Cloud\Notebooks\V1\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\Notebooks\V1\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/GetInstance',
        $argument,
        ['\Google\Cloud\Notebooks\V1\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Instance in a given project and location.
     * @param \Google\Cloud\Notebooks\V1\CreateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateInstance(\Google\Cloud\Notebooks\V1\CreateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/CreateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Registers an existing legacy notebook instance to the Notebooks API server.
     * Legacy instances are instances created with the legacy Compute Engine
     * calls. They are not manageable by the Notebooks API out of the box. This
     * call makes these instances manageable by the Notebooks API.
     * @param \Google\Cloud\Notebooks\V1\RegisterInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RegisterInstance(\Google\Cloud\Notebooks\V1\RegisterInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/RegisterInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the guest accelerators of a single Instance.
     * @param \Google\Cloud\Notebooks\V1\SetInstanceAcceleratorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetInstanceAccelerator(\Google\Cloud\Notebooks\V1\SetInstanceAcceleratorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/SetInstanceAccelerator',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the machine type of a single Instance.
     * @param \Google\Cloud\Notebooks\V1\SetInstanceMachineTypeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetInstanceMachineType(\Google\Cloud\Notebooks\V1\SetInstanceMachineTypeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/SetInstanceMachineType',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update Notebook Instance configurations.
     * @param \Google\Cloud\Notebooks\V1\UpdateInstanceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateInstanceConfig(\Google\Cloud\Notebooks\V1\UpdateInstanceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/UpdateInstanceConfig',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the Shielded instance configuration of a single Instance.
     * @param \Google\Cloud\Notebooks\V1\UpdateShieldedInstanceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateShieldedInstanceConfig(\Google\Cloud\Notebooks\V1\UpdateShieldedInstanceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/UpdateShieldedInstanceConfig',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Replaces all the labels of an Instance.
     * @param \Google\Cloud\Notebooks\V1\SetInstanceLabelsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetInstanceLabels(\Google\Cloud\Notebooks\V1\SetInstanceLabelsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/SetInstanceLabels',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Add/update metadata items for an instance.
     * @param \Google\Cloud\Notebooks\V1\UpdateInstanceMetadataItemsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateInstanceMetadataItems(\Google\Cloud\Notebooks\V1\UpdateInstanceMetadataItemsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/UpdateInstanceMetadataItems',
        $argument,
        ['\Google\Cloud\Notebooks\V1\UpdateInstanceMetadataItemsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Instance.
     * @param \Google\Cloud\Notebooks\V1\DeleteInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInstance(\Google\Cloud\Notebooks\V1\DeleteInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/DeleteInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a notebook instance.
     * @param \Google\Cloud\Notebooks\V1\StartInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartInstance(\Google\Cloud\Notebooks\V1\StartInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/StartInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops a notebook instance.
     * @param \Google\Cloud\Notebooks\V1\StopInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopInstance(\Google\Cloud\Notebooks\V1\StopInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/StopInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets a notebook instance.
     * @param \Google\Cloud\Notebooks\V1\ResetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetInstance(\Google\Cloud\Notebooks\V1\ResetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/ResetInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Allows notebook instances to
     * report their latest instance information to the Notebooks
     * API server. The server will merge the reported information to
     * the instance metadata store. Do not use this method directly.
     * @param \Google\Cloud\Notebooks\V1\ReportInstanceInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReportInstanceInfo(\Google\Cloud\Notebooks\V1\ReportInstanceInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/ReportInstanceInfo',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Check if a notebook instance is upgradable.
     * @param \Google\Cloud\Notebooks\V1\IsInstanceUpgradeableRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function IsInstanceUpgradeable(\Google\Cloud\Notebooks\V1\IsInstanceUpgradeableRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/IsInstanceUpgradeable',
        $argument,
        ['\Google\Cloud\Notebooks\V1\IsInstanceUpgradeableResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Check if a notebook instance is healthy.
     * @param \Google\Cloud\Notebooks\V1\GetInstanceHealthRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstanceHealth(\Google\Cloud\Notebooks\V1\GetInstanceHealthRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/GetInstanceHealth',
        $argument,
        ['\Google\Cloud\Notebooks\V1\GetInstanceHealthResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Upgrades a notebook instance to the latest version.
     * @param \Google\Cloud\Notebooks\V1\UpgradeInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpgradeInstance(\Google\Cloud\Notebooks\V1\UpgradeInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/UpgradeInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Rollbacks a notebook instance to the previous version.
     * @param \Google\Cloud\Notebooks\V1\RollbackInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RollbackInstance(\Google\Cloud\Notebooks\V1\RollbackInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/RollbackInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Diagnostic File and runs Diagnostic Tool given an Instance.
     * @param \Google\Cloud\Notebooks\V1\DiagnoseInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DiagnoseInstance(\Google\Cloud\Notebooks\V1\DiagnoseInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/DiagnoseInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Allows notebook instances to
     * call this endpoint to upgrade themselves. Do not use this method directly.
     * @param \Google\Cloud\Notebooks\V1\UpgradeInstanceInternalRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpgradeInstanceInternal(\Google\Cloud\Notebooks\V1\UpgradeInstanceInternalRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/UpgradeInstanceInternal',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists environments in a project.
     * @param \Google\Cloud\Notebooks\V1\ListEnvironmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEnvironments(\Google\Cloud\Notebooks\V1\ListEnvironmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/ListEnvironments',
        $argument,
        ['\Google\Cloud\Notebooks\V1\ListEnvironmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Environment.
     * @param \Google\Cloud\Notebooks\V1\GetEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEnvironment(\Google\Cloud\Notebooks\V1\GetEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/GetEnvironment',
        $argument,
        ['\Google\Cloud\Notebooks\V1\Environment', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Environment.
     * @param \Google\Cloud\Notebooks\V1\CreateEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEnvironment(\Google\Cloud\Notebooks\V1\CreateEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/CreateEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Environment.
     * @param \Google\Cloud\Notebooks\V1\DeleteEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEnvironment(\Google\Cloud\Notebooks\V1\DeleteEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/DeleteEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists schedules in a given project and location.
     * @param \Google\Cloud\Notebooks\V1\ListSchedulesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSchedules(\Google\Cloud\Notebooks\V1\ListSchedulesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/ListSchedules',
        $argument,
        ['\Google\Cloud\Notebooks\V1\ListSchedulesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of schedule
     * @param \Google\Cloud\Notebooks\V1\GetScheduleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSchedule(\Google\Cloud\Notebooks\V1\GetScheduleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/GetSchedule',
        $argument,
        ['\Google\Cloud\Notebooks\V1\Schedule', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes schedule and all underlying jobs
     * @param \Google\Cloud\Notebooks\V1\DeleteScheduleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSchedule(\Google\Cloud\Notebooks\V1\DeleteScheduleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/DeleteSchedule',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Scheduled Notebook in a given project and location.
     * @param \Google\Cloud\Notebooks\V1\CreateScheduleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSchedule(\Google\Cloud\Notebooks\V1\CreateScheduleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/CreateSchedule',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Triggers execution of an existing schedule.
     * @param \Google\Cloud\Notebooks\V1\TriggerScheduleRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TriggerSchedule(\Google\Cloud\Notebooks\V1\TriggerScheduleRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/TriggerSchedule',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists executions in a given project and location
     * @param \Google\Cloud\Notebooks\V1\ListExecutionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListExecutions(\Google\Cloud\Notebooks\V1\ListExecutionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/ListExecutions',
        $argument,
        ['\Google\Cloud\Notebooks\V1\ListExecutionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of executions
     * @param \Google\Cloud\Notebooks\V1\GetExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetExecution(\Google\Cloud\Notebooks\V1\GetExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/GetExecution',
        $argument,
        ['\Google\Cloud\Notebooks\V1\Execution', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes execution
     * @param \Google\Cloud\Notebooks\V1\DeleteExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteExecution(\Google\Cloud\Notebooks\V1\DeleteExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/DeleteExecution',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Execution in a given project and location.
     * @param \Google\Cloud\Notebooks\V1\CreateExecutionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateExecution(\Google\Cloud\Notebooks\V1\CreateExecutionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.notebooks.v1.NotebookService/CreateExecution',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
