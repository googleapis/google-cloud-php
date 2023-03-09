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
 * The Dataflow Metrics API lets you monitor the progress of Dataflow
 * jobs.
 */
class MetricsV1Beta3GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Request the job status.
     *
     * To request the status of a job, we recommend using
     * `projects.locations.jobs.getMetrics` with a [regional endpoint]
     * (https://cloud.google.com/dataflow/docs/concepts/regional-endpoints). Using
     * `projects.jobs.getMetrics` is not recommended, as you can only request the
     * status of jobs that are running in `us-central1`.
     * @param \Google\Cloud\Dataflow\V1beta3\GetJobMetricsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJobMetrics(\Google\Cloud\Dataflow\V1beta3\GetJobMetricsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.MetricsV1Beta3/GetJobMetrics',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\JobMetrics', 'decode'],
        $metadata, $options);
    }

    /**
     * Request detailed information about the execution status of the job.
     *
     * EXPERIMENTAL.  This API is subject to change or removal without notice.
     * @param \Google\Cloud\Dataflow\V1beta3\GetJobExecutionDetailsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetJobExecutionDetails(\Google\Cloud\Dataflow\V1beta3\GetJobExecutionDetailsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.MetricsV1Beta3/GetJobExecutionDetails',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\JobExecutionDetails', 'decode'],
        $metadata, $options);
    }

    /**
     * Request detailed information about the execution status of a stage of the
     * job.
     *
     * EXPERIMENTAL.  This API is subject to change or removal without notice.
     * @param \Google\Cloud\Dataflow\V1beta3\GetStageExecutionDetailsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetStageExecutionDetails(\Google\Cloud\Dataflow\V1beta3\GetStageExecutionDetailsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.dataflow.v1beta3.MetricsV1Beta3/GetStageExecutionDetails',
        $argument,
        ['\Google\Cloud\Dataflow\V1beta3\StageExecutionDetails', 'decode'],
        $metadata, $options);
    }

}
