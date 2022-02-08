<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\OsConfig\V1;

/**
 * OS Config API
 *
 * The OS Config service is a server-side component that you can use to
 * manage package installations and patch jobs for virtual machine instances.
 */
class OsConfigServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Patch VM instances by creating and running a patch job.
     * @param \Google\Cloud\OsConfig\V1\ExecutePatchJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExecutePatchJob(\Google\Cloud\OsConfig\V1\ExecutePatchJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/ExecutePatchJob',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the patch job. This can be used to track the progress of an
     * ongoing patch job or review the details of completed jobs.
     * @param \Google\Cloud\OsConfig\V1\GetPatchJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPatchJob(\Google\Cloud\OsConfig\V1\GetPatchJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/GetPatchJob',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancel a patch job. The patch job must be active. Canceled patch jobs
     * cannot be restarted.
     * @param \Google\Cloud\OsConfig\V1\CancelPatchJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelPatchJob(\Google\Cloud\OsConfig\V1\CancelPatchJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/CancelPatchJob',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a list of patch jobs.
     * @param \Google\Cloud\OsConfig\V1\ListPatchJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPatchJobs(\Google\Cloud\OsConfig\V1\ListPatchJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/ListPatchJobs',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListPatchJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a list of instance details for a given patch job.
     * @param \Google\Cloud\OsConfig\V1\ListPatchJobInstanceDetailsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPatchJobInstanceDetails(\Google\Cloud\OsConfig\V1\ListPatchJobInstanceDetailsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/ListPatchJobInstanceDetails',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListPatchJobInstanceDetailsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Create an OS Config patch deployment.
     * @param \Google\Cloud\OsConfig\V1\CreatePatchDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePatchDeployment(\Google\Cloud\OsConfig\V1\CreatePatchDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/CreatePatchDeployment',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Get an OS Config patch deployment.
     * @param \Google\Cloud\OsConfig\V1\GetPatchDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPatchDeployment(\Google\Cloud\OsConfig\V1\GetPatchDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/GetPatchDeployment',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a page of OS Config patch deployments.
     * @param \Google\Cloud\OsConfig\V1\ListPatchDeploymentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPatchDeployments(\Google\Cloud\OsConfig\V1\ListPatchDeploymentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/ListPatchDeployments',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListPatchDeploymentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete an OS Config patch deployment.
     * @param \Google\Cloud\OsConfig\V1\DeletePatchDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePatchDeployment(\Google\Cloud\OsConfig\V1\DeletePatchDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/DeletePatchDeployment',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Update an OS Config patch deployment.
     * @param \Google\Cloud\OsConfig\V1\UpdatePatchDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePatchDeployment(\Google\Cloud\OsConfig\V1\UpdatePatchDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/UpdatePatchDeployment',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Change state of patch deployment to "PAUSED".
     * Patch deployment in paused state doesn't generate patch jobs.
     * @param \Google\Cloud\OsConfig\V1\PausePatchDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PausePatchDeployment(\Google\Cloud\OsConfig\V1\PausePatchDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/PausePatchDeployment',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchDeployment', 'decode'],
        $metadata, $options);
    }

    /**
     * Change state of patch deployment back to "ACTIVE".
     * Patch deployment in active state continues to generate patch jobs.
     * @param \Google\Cloud\OsConfig\V1\ResumePatchDeploymentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumePatchDeployment(\Google\Cloud\OsConfig\V1\ResumePatchDeploymentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigService/ResumePatchDeployment',
        $argument,
        ['\Google\Cloud\OsConfig\V1\PatchDeployment', 'decode'],
        $metadata, $options);
    }

}
