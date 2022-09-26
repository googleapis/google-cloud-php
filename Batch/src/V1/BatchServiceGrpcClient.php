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
namespace Google\Cloud\Batch\V1;

/**
 * Google Batch Service.
 * The service manages user submitted batch jobs and allocates Google Compute
 * Engine VM instances to run the jobs.
 */
class BatchServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a Job.
     * @param \Google\Cloud\Batch\V1\CreateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateJob(\Google\Cloud\Batch\V1\CreateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.batch.v1.BatchService/CreateJob',
        $argument,
        ['\Google\Cloud\Batch\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a Job specified by its resource name.
     * @param \Google\Cloud\Batch\V1\GetJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJob(\Google\Cloud\Batch\V1\GetJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.batch.v1.BatchService/GetJob',
        $argument,
        ['\Google\Cloud\Batch\V1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a Job.
     * @param \Google\Cloud\Batch\V1\DeleteJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteJob(\Google\Cloud\Batch\V1\DeleteJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.batch.v1.BatchService/DeleteJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List all Jobs for a project within a region.
     * @param \Google\Cloud\Batch\V1\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobs(\Google\Cloud\Batch\V1\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.batch.v1.BatchService/ListJobs',
        $argument,
        ['\Google\Cloud\Batch\V1\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Return a single Task.
     * @param \Google\Cloud\Batch\V1\GetTaskRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTask(\Google\Cloud\Batch\V1\GetTaskRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.batch.v1.BatchService/GetTask',
        $argument,
        ['\Google\Cloud\Batch\V1\Task', 'decode'],
        $metadata, $options);
    }

    /**
     * List Tasks associated with a job.
     * @param \Google\Cloud\Batch\V1\ListTasksRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTasks(\Google\Cloud\Batch\V1\ListTasksRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.batch.v1.BatchService/ListTasks',
        $argument,
        ['\Google\Cloud\Batch\V1\ListTasksResponse', 'decode'],
        $metadata, $options);
    }

}
