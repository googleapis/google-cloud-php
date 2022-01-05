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
namespace Google\Cloud\Scheduler\V1beta1;

/**
 * The Cloud Scheduler API allows external entities to reliably
 * schedule asynchronous jobs.
 */
class CloudSchedulerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists jobs.
     * @param \Google\Cloud\Scheduler\V1beta1\ListJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListJobs(\Google\Cloud\Scheduler\V1beta1\ListJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/ListJobs',
        $argument,
        ['\Google\Cloud\Scheduler\V1beta1\ListJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a job.
     * @param \Google\Cloud\Scheduler\V1beta1\GetJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJob(\Google\Cloud\Scheduler\V1beta1\GetJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/GetJob',
        $argument,
        ['\Google\Cloud\Scheduler\V1beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a job.
     * @param \Google\Cloud\Scheduler\V1beta1\CreateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateJob(\Google\Cloud\Scheduler\V1beta1\CreateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/CreateJob',
        $argument,
        ['\Google\Cloud\Scheduler\V1beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a job.
     *
     * If successful, the updated [Job][google.cloud.scheduler.v1beta1.Job] is returned. If the job does
     * not exist, `NOT_FOUND` is returned.
     *
     * If UpdateJob does not successfully return, it is possible for the
     * job to be in an [Job.State.UPDATE_FAILED][google.cloud.scheduler.v1beta1.Job.State.UPDATE_FAILED] state. A job in this state may
     * not be executed. If this happens, retry the UpdateJob request
     * until a successful response is received.
     * @param \Google\Cloud\Scheduler\V1beta1\UpdateJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateJob(\Google\Cloud\Scheduler\V1beta1\UpdateJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/UpdateJob',
        $argument,
        ['\Google\Cloud\Scheduler\V1beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a job.
     * @param \Google\Cloud\Scheduler\V1beta1\DeleteJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteJob(\Google\Cloud\Scheduler\V1beta1\DeleteJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/DeleteJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses a job.
     *
     * If a job is paused then the system will stop executing the job
     * until it is re-enabled via [ResumeJob][google.cloud.scheduler.v1beta1.CloudScheduler.ResumeJob]. The
     * state of the job is stored in [state][google.cloud.scheduler.v1beta1.Job.state]; if paused it
     * will be set to [Job.State.PAUSED][google.cloud.scheduler.v1beta1.Job.State.PAUSED]. A job must be in [Job.State.ENABLED][google.cloud.scheduler.v1beta1.Job.State.ENABLED]
     * to be paused.
     * @param \Google\Cloud\Scheduler\V1beta1\PauseJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseJob(\Google\Cloud\Scheduler\V1beta1\PauseJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/PauseJob',
        $argument,
        ['\Google\Cloud\Scheduler\V1beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Resume a job.
     *
     * This method reenables a job after it has been [Job.State.PAUSED][google.cloud.scheduler.v1beta1.Job.State.PAUSED]. The
     * state of a job is stored in [Job.state][google.cloud.scheduler.v1beta1.Job.state]; after calling this method it
     * will be set to [Job.State.ENABLED][google.cloud.scheduler.v1beta1.Job.State.ENABLED]. A job must be in
     * [Job.State.PAUSED][google.cloud.scheduler.v1beta1.Job.State.PAUSED] to be resumed.
     * @param \Google\Cloud\Scheduler\V1beta1\ResumeJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeJob(\Google\Cloud\Scheduler\V1beta1\ResumeJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/ResumeJob',
        $argument,
        ['\Google\Cloud\Scheduler\V1beta1\Job', 'decode'],
        $metadata, $options);
    }

    /**
     * Forces a job to run now.
     *
     * When this method is called, Cloud Scheduler will dispatch the job, even
     * if the job is already running.
     * @param \Google\Cloud\Scheduler\V1beta1\RunJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunJob(\Google\Cloud\Scheduler\V1beta1\RunJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.scheduler.v1beta1.CloudScheduler/RunJob',
        $argument,
        ['\Google\Cloud\Scheduler\V1beta1\Job', 'decode'],
        $metadata, $options);
    }

}
