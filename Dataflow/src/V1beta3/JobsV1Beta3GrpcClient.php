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
namespace Google\Cloud\Dataflow\V1beta3;

/**
 * Provides a method to create and modify Google Cloud Dataflow jobs.
 * A Job is a multi-stage computation graph run by the Cloud Dataflow service.
 */
class JobsV1Beta3GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a Cloud Dataflow job.
     *
     * To create a job, we recommend using `projects.locations.jobs.create` with a
     * [regional endpoint]
     * (https://cloud.google.com/dataflow/docs/concepts/regional-endpoints). Using
     * `projects.jobs.create` is not recommended, as your job will always start
     * in `us-central1`.
     * @param \Google\Cloud\Dataflow\V1beta3\CreateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateJob(\Google\Cloud\Dataflow\V1beta3\CreateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.JobsV1Beta3/CreateJob',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the state of the specified Cloud Dataflow job.
     *
     * To get the state of a job, we recommend using `projects.locations.jobs.get`
     * with a [regional endpoint]
     * (https://cloud.google.com/dataflow/docs/concepts/regional-endpoints). Using
     * `projects.jobs.get` is not recommended, as you can only get the state of
     * jobs that are running in `us-central1`.
     * @param \Google\Cloud\Dataflow\V1beta3\GetJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJob(\Google\Cloud\Dataflow\V1beta3\GetJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.JobsV1Beta3/GetJob',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the state of an existing Cloud Dataflow job.
     *
     * To update the state of an existing job, we recommend using
     * `projects.locations.jobs.update` with a [regional endpoint]
     * (https://cloud.google.com/dataflow/docs/concepts/regional-endpoints). Using
     * `projects.jobs.update` is not recommended, as you can only update the state
     * of jobs that are running in `us-central1`.
     * @param \Google\Cloud\Dataflow\V1beta3\UpdateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateJob(\Google\Cloud\Dataflow\V1beta3\UpdateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.JobsV1Beta3/UpdateJob',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * List the jobs of a project.
     *
     * To list the jobs of a project in a region, we recommend using
     * `projects.locations.jobs.list` with a [regional endpoint]
     * (https://cloud.google.com/dataflow/docs/concepts/regional-endpoints). To
     * list the all jobs across all regions, use `projects.jobs.aggregated`. Using
     * `projects.jobs.list` is not recommended, as you can only get the list of
     * jobs that are running in `us-central1`.
     * @param \Google\Cloud\Dataflow\V1beta3\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobs(\Google\Cloud\Dataflow\V1beta3\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.JobsV1Beta3/ListJobs',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List the jobs of a project across all regions.
     * @param \Google\Cloud\Dataflow\V1beta3\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AggregatedListJobs(\Google\Cloud\Dataflow\V1beta3\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.JobsV1Beta3/AggregatedListJobs',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Check for existence of active jobs in the given project across all regions.
     * @param \Google\Cloud\Dataflow\V1beta3\CheckActiveJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CheckActiveJobs(\Google\Cloud\Dataflow\V1beta3\CheckActiveJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.JobsV1Beta3/CheckActiveJobs',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\CheckActiveJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Snapshot the state of a streaming job.
     * @param \Google\Cloud\Dataflow\V1beta3\SnapshotJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SnapshotJob(\Google\Cloud\Dataflow\V1beta3\SnapshotJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.JobsV1Beta3/SnapshotJob',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\Snapshot', 'decode'],
        $metadata, $options);
    }

}
