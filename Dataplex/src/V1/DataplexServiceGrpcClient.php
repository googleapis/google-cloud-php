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
namespace Google\Cloud\Dataplex\V1;

/**
 * Dataplex service provides data lakes as a service. The primary resources
 * offered by this service are Lakes, Zones and Assets which collectively allow
 * a data adminstrator to organize, manage, secure and catalog data across their
 * organization located across cloud projects in a variety of storage systems
 * including Cloud Storage and BigQuery.
 */
class DataplexServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a lake resource.
     * @param \Google\Cloud\Dataplex\V1\CreateLakeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateLake(\Google\Cloud\Dataplex\V1\CreateLakeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/CreateLake',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a lake resource.
     * @param \Google\Cloud\Dataplex\V1\UpdateLakeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateLake(\Google\Cloud\Dataplex\V1\UpdateLakeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/UpdateLake',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a lake resource. All zones within the lake must be deleted before
     * the lake can be deleted.
     * @param \Google\Cloud\Dataplex\V1\DeleteLakeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteLake(\Google\Cloud\Dataplex\V1\DeleteLakeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/DeleteLake',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists lake resources in a project and location.
     * @param \Google\Cloud\Dataplex\V1\ListLakesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLakes(\Google\Cloud\Dataplex\V1\ListLakesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListLakes',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListLakesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a lake resource.
     * @param \Google\Cloud\Dataplex\V1\GetLakeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLake(\Google\Cloud\Dataplex\V1\GetLakeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/GetLake',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Lake', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists action resources in a lake.
     * @param \Google\Cloud\Dataplex\V1\ListLakeActionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListLakeActions(\Google\Cloud\Dataplex\V1\ListLakeActionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListLakeActions',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListActionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a zone resource within a lake.
     * @param \Google\Cloud\Dataplex\V1\CreateZoneRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateZone(\Google\Cloud\Dataplex\V1\CreateZoneRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/CreateZone',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a zone resource.
     * @param \Google\Cloud\Dataplex\V1\UpdateZoneRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateZone(\Google\Cloud\Dataplex\V1\UpdateZoneRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/UpdateZone',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a zone resource. All assets within a zone must be deleted before
     * the zone can be deleted.
     * @param \Google\Cloud\Dataplex\V1\DeleteZoneRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteZone(\Google\Cloud\Dataplex\V1\DeleteZoneRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/DeleteZone',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists zone resources in a lake.
     * @param \Google\Cloud\Dataplex\V1\ListZonesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListZones(\Google\Cloud\Dataplex\V1\ListZonesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListZones',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListZonesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a zone resource.
     * @param \Google\Cloud\Dataplex\V1\GetZoneRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetZone(\Google\Cloud\Dataplex\V1\GetZoneRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/GetZone',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Zone', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists action resources in a zone.
     * @param \Google\Cloud\Dataplex\V1\ListZoneActionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListZoneActions(\Google\Cloud\Dataplex\V1\ListZoneActionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListZoneActions',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListActionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an asset resource.
     * @param \Google\Cloud\Dataplex\V1\CreateAssetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAsset(\Google\Cloud\Dataplex\V1\CreateAssetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/CreateAsset',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an asset resource.
     * @param \Google\Cloud\Dataplex\V1\UpdateAssetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAsset(\Google\Cloud\Dataplex\V1\UpdateAssetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/UpdateAsset',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an asset resource. The referenced storage resource is detached
     * (default) or deleted based on the associated Lifecycle policy.
     * @param \Google\Cloud\Dataplex\V1\DeleteAssetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAsset(\Google\Cloud\Dataplex\V1\DeleteAssetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/DeleteAsset',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists asset resources in a zone.
     * @param \Google\Cloud\Dataplex\V1\ListAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAssets(\Google\Cloud\Dataplex\V1\ListAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListAssets',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListAssetsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves an asset resource.
     * @param \Google\Cloud\Dataplex\V1\GetAssetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAsset(\Google\Cloud\Dataplex\V1\GetAssetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/GetAsset',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Asset', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists action resources in an asset.
     * @param \Google\Cloud\Dataplex\V1\ListAssetActionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAssetActions(\Google\Cloud\Dataplex\V1\ListAssetActionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListAssetActions',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListActionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a task resource within a lake.
     * @param \Google\Cloud\Dataplex\V1\CreateTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTask(\Google\Cloud\Dataplex\V1\CreateTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/CreateTask',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update the task resource.
     * @param \Google\Cloud\Dataplex\V1\UpdateTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTask(\Google\Cloud\Dataplex\V1\UpdateTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/UpdateTask',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete the task resource.
     * @param \Google\Cloud\Dataplex\V1\DeleteTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTask(\Google\Cloud\Dataplex\V1\DeleteTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/DeleteTask',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists tasks under the given lake.
     * @param \Google\Cloud\Dataplex\V1\ListTasksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTasks(\Google\Cloud\Dataplex\V1\ListTasksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListTasks',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListTasksResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get task resource.
     * @param \Google\Cloud\Dataplex\V1\GetTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTask(\Google\Cloud\Dataplex\V1\GetTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/GetTask',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Jobs under the given task.
     * @param \Google\Cloud\Dataplex\V1\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobs(\Google\Cloud\Dataplex\V1\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListJobs',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get job resource.
     * @param \Google\Cloud\Dataplex\V1\GetJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJob(\Google\Cloud\Dataplex\V1\GetJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/GetJob',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancel jobs running for the task resource.
     * @param \Google\Cloud\Dataplex\V1\CancelJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelJob(\Google\Cloud\Dataplex\V1\CancelJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/CancelJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Create an environment resource.
     * @param \Google\Cloud\Dataplex\V1\CreateEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEnvironment(\Google\Cloud\Dataplex\V1\CreateEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/CreateEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update the environment resource.
     * @param \Google\Cloud\Dataplex\V1\UpdateEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEnvironment(\Google\Cloud\Dataplex\V1\UpdateEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/UpdateEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete the environment resource. All the child resources must have been
     * deleted before environment deletion can be initiated.
     * @param \Google\Cloud\Dataplex\V1\DeleteEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEnvironment(\Google\Cloud\Dataplex\V1\DeleteEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/DeleteEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists environments under the given lake.
     * @param \Google\Cloud\Dataplex\V1\ListEnvironmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEnvironments(\Google\Cloud\Dataplex\V1\ListEnvironmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListEnvironments',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListEnvironmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get environment resource.
     * @param \Google\Cloud\Dataplex\V1\GetEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEnvironment(\Google\Cloud\Dataplex\V1\GetEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/GetEnvironment',
        $argument,
        ['\Google\Cloud\Dataplex\V1\Environment', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists session resources in an environment.
     * @param \Google\Cloud\Dataplex\V1\ListSessionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSessions(\Google\Cloud\Dataplex\V1\ListSessionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataplexService/ListSessions',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListSessionsResponse', 'decode'],
        $metadata, $options);
    }

}
