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
namespace Google\Cloud\Dataproc\V1;

/**
 * The JobController provides methods to manage jobs.
 */
class JobControllerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Submits a job to a cluster.
     * @param \Google\Cloud\Dataproc\V1\SubmitJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SubmitJob(\Google\Cloud\Dataproc\V1\SubmitJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.JobController/SubmitJob',
        $argument,
        ['\Google\Cloud\Dataproc\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Submits job to a cluster.
     * @param \Google\Cloud\Dataproc\V1\SubmitJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SubmitJobAsOperation(\Google\Cloud\Dataproc\V1\SubmitJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.JobController/SubmitJobAsOperation',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the resource representation for a job in a project.
     * @param \Google\Cloud\Dataproc\V1\GetJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJob(\Google\Cloud\Dataproc\V1\GetJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.JobController/GetJob',
        $argument,
        ['\Google\Cloud\Dataproc\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists regions/{region}/jobs in a project.
     * @param \Google\Cloud\Dataproc\V1\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobs(\Google\Cloud\Dataproc\V1\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.JobController/ListJobs',
        $argument,
        ['\Google\Cloud\Dataproc\V1\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a job in a project.
     * @param \Google\Cloud\Dataproc\V1\UpdateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateJob(\Google\Cloud\Dataproc\V1\UpdateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.JobController/UpdateJob',
        $argument,
        ['\Google\Cloud\Dataproc\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts a job cancellation request. To access the job resource
     * after cancellation, call
     * [regions/{region}/jobs.list](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/list)
     * or
     * [regions/{region}/jobs.get](https://cloud.google.com/dataproc/docs/reference/rest/v1/projects.regions.jobs/get).
     * @param \Google\Cloud\Dataproc\V1\CancelJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelJob(\Google\Cloud\Dataproc\V1\CancelJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.JobController/CancelJob',
        $argument,
        ['\Google\Cloud\Dataproc\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the job from the project. If the job is active, the delete fails,
     * and the response returns `FAILED_PRECONDITION`.
     * @param \Google\Cloud\Dataproc\V1\DeleteJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteJob(\Google\Cloud\Dataproc\V1\DeleteJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataproc.v1.JobController/DeleteJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
