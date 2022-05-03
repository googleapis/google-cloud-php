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
namespace Google\Cloud\StorageTransfer\V1;

/**
 * Storage Transfer Service and its protos.
 * Transfers data between between Google Cloud Storage buckets or from a data
 * source external to Google to a Cloud Storage bucket.
 */
class StorageTransferServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns the Google service account that is used by Storage Transfer
     * Service to access buckets in the project where transfers
     * run or in other projects. Each Google service account is associated
     * with one Google Cloud project. Users
     * should add this service account to the Google Cloud Storage bucket
     * ACLs to grant access to Storage Transfer Service. This service
     * account is created and owned by Storage Transfer Service and can
     * only be used by Storage Transfer Service.
     * @param \Google\Cloud\StorageTransfer\V1\GetGoogleServiceAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGoogleServiceAccount(\Google\Cloud\StorageTransfer\V1\GetGoogleServiceAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/GetGoogleServiceAccount',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\GoogleServiceAccount', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a transfer job that runs periodically.
     * @param \Google\Cloud\StorageTransfer\V1\CreateTransferJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTransferJob(\Google\Cloud\StorageTransfer\V1\CreateTransferJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/CreateTransferJob',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\TransferJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a transfer job. Updating a job's transfer spec does not affect
     * transfer operations that are running already.
     *
     * **Note:** The job's [status][google.storagetransfer.v1.TransferJob.status] field can be modified
     * using this RPC (for example, to set a job's status to
     * [DELETED][google.storagetransfer.v1.TransferJob.Status.DELETED],
     * [DISABLED][google.storagetransfer.v1.TransferJob.Status.DISABLED], or
     * [ENABLED][google.storagetransfer.v1.TransferJob.Status.ENABLED]).
     * @param \Google\Cloud\StorageTransfer\V1\UpdateTransferJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTransferJob(\Google\Cloud\StorageTransfer\V1\UpdateTransferJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/UpdateTransferJob',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\TransferJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a transfer job.
     * @param \Google\Cloud\StorageTransfer\V1\GetTransferJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTransferJob(\Google\Cloud\StorageTransfer\V1\GetTransferJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/GetTransferJob',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\TransferJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists transfer jobs.
     * @param \Google\Cloud\StorageTransfer\V1\ListTransferJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTransferJobs(\Google\Cloud\StorageTransfer\V1\ListTransferJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/ListTransferJobs',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\ListTransferJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses a transfer operation.
     * @param \Google\Cloud\StorageTransfer\V1\PauseTransferOperationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseTransferOperation(\Google\Cloud\StorageTransfer\V1\PauseTransferOperationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/PauseTransferOperation',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Resumes a transfer operation that is paused.
     * @param \Google\Cloud\StorageTransfer\V1\ResumeTransferOperationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeTransferOperation(\Google\Cloud\StorageTransfer\V1\ResumeTransferOperationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/ResumeTransferOperation',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Attempts to start a new TransferOperation for the current TransferJob. A
     * TransferJob has a maximum of one active TransferOperation. If this method
     * is called while a TransferOperation is active, an error will be returned.
     * @param \Google\Cloud\StorageTransfer\V1\RunTransferJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunTransferJob(\Google\Cloud\StorageTransfer\V1\RunTransferJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/RunTransferJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an agent pool resource.
     * @param \Google\Cloud\StorageTransfer\V1\CreateAgentPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAgentPool(\Google\Cloud\StorageTransfer\V1\CreateAgentPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/CreateAgentPool',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\AgentPool', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing agent pool resource.
     * @param \Google\Cloud\StorageTransfer\V1\UpdateAgentPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAgentPool(\Google\Cloud\StorageTransfer\V1\UpdateAgentPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/UpdateAgentPool',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\AgentPool', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an agent pool.
     * @param \Google\Cloud\StorageTransfer\V1\GetAgentPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAgentPool(\Google\Cloud\StorageTransfer\V1\GetAgentPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/GetAgentPool',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\AgentPool', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists agent pools.
     * @param \Google\Cloud\StorageTransfer\V1\ListAgentPoolsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAgentPools(\Google\Cloud\StorageTransfer\V1\ListAgentPoolsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/ListAgentPools',
        $argument,
        ['\Google\Cloud\StorageTransfer\V1\ListAgentPoolsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an agent pool.
     * @param \Google\Cloud\StorageTransfer\V1\DeleteAgentPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAgentPool(\Google\Cloud\StorageTransfer\V1\DeleteAgentPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.storagetransfer.v1.StorageTransferService/DeleteAgentPool',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
