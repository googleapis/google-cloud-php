<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2019 Google LLC.
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
//
namespace Google\Cloud\Talent\V4beta1;

/**
 * A service handles job management, including job CRUD, enumeration and search.
 */
class JobServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new job.
     *
     * Typically, the job becomes searchable within 10 seconds, but it may take
     * up to 5 minutes.
     * @param \Google\Cloud\Talent\V4beta1\CreateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function CreateJob(\Google\Cloud\Talent\V4beta1\CreateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/CreateJob',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the specified job, whose status is OPEN or recently EXPIRED
     * within the last 90 days.
     * @param \Google\Cloud\Talent\V4beta1\GetJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function GetJob(\Google\Cloud\Talent\V4beta1\GetJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/GetJob',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates specified job.
     *
     * Typically, updated contents become visible in search results within 10
     * seconds, but it may take up to 5 minutes.
     * @param \Google\Cloud\Talent\V4beta1\UpdateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function UpdateJob(\Google\Cloud\Talent\V4beta1\UpdateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/UpdateJob',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified job.
     *
     * Typically, the job becomes unsearchable within 10 seconds, but it may take
     * up to 5 minutes.
     * @param \Google\Cloud\Talent\V4beta1\DeleteJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function DeleteJob(\Google\Cloud\Talent\V4beta1\DeleteJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/DeleteJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists jobs by filter.
     * @param \Google\Cloud\Talent\V4beta1\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function ListJobs(\Google\Cloud\Talent\V4beta1\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/ListJobs',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a list of [Job][google.cloud.talent.v4beta1.Job]s by filter.
     * @param \Google\Cloud\Talent\V4beta1\BatchDeleteJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchDeleteJobs(\Google\Cloud\Talent\V4beta1\BatchDeleteJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/BatchDeleteJobs',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches for jobs using the provided
     * [SearchJobsRequest][google.cloud.talent.v4beta1.SearchJobsRequest].
     *
     * This call constrains the
     * [visibility][google.cloud.talent.v4beta1.Job.visibility] of jobs present in
     * the database, and only returns jobs that the caller has permission to
     * search against.
     * @param \Google\Cloud\Talent\V4beta1\SearchJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SearchJobs(\Google\Cloud\Talent\V4beta1\SearchJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/SearchJobs',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\SearchJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches for jobs using the provided
     * [SearchJobsRequest][google.cloud.talent.v4beta1.SearchJobsRequest].
     *
     * This API call is intended for the use case of targeting passive job
     * seekers (for example, job seekers who have signed up to receive email
     * alerts about potential job opportunities), and has different algorithmic
     * adjustments that are targeted to passive job seekers.
     *
     * This call constrains the
     * [visibility][google.cloud.talent.v4beta1.Job.visibility] of jobs present in
     * the database, and only returns jobs the caller has permission to search
     * against.
     * @param \Google\Cloud\Talent\V4beta1\SearchJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function SearchJobsForAlert(\Google\Cloud\Talent\V4beta1\SearchJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/SearchJobsForAlert',
        $argument,
        ['\Google\Cloud\Talent\V4beta1\SearchJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Begins executing a batch create jobs operation.
     * @param \Google\Cloud\Talent\V4beta1\BatchCreateJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchCreateJobs(\Google\Cloud\Talent\V4beta1\BatchCreateJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/BatchCreateJobs',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Begins executing a batch update jobs operation.
     * @param \Google\Cloud\Talent\V4beta1\BatchUpdateJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function BatchUpdateJobs(\Google\Cloud\Talent\V4beta1\BatchUpdateJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.talent.v4beta1.JobService/BatchUpdateJobs',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
