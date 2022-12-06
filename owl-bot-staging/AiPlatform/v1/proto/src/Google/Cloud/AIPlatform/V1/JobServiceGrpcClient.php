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
namespace Google\Cloud\AIPlatform\V1;

/**
 * A service for creating and managing Vertex AI's jobs.
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
     * Creates a CustomJob. A created CustomJob right away
     * will be attempted to be run.
     * @param \Google\Cloud\AIPlatform\V1\CreateCustomJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCustomJob(\Google\Cloud\AIPlatform\V1\CreateCustomJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CreateCustomJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\CustomJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a CustomJob.
     * @param \Google\Cloud\AIPlatform\V1\GetCustomJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCustomJob(\Google\Cloud\AIPlatform\V1\GetCustomJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/GetCustomJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\CustomJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CustomJobs in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListCustomJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCustomJobs(\Google\Cloud\AIPlatform\V1\ListCustomJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/ListCustomJobs',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListCustomJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a CustomJob.
     * @param \Google\Cloud\AIPlatform\V1\DeleteCustomJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCustomJob(\Google\Cloud\AIPlatform\V1\DeleteCustomJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/DeleteCustomJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a CustomJob.
     * Starts asynchronous cancellation on the CustomJob. The server
     * makes a best effort to cancel the job, but success is not
     * guaranteed. Clients can use [JobService.GetCustomJob][google.cloud.aiplatform.v1.JobService.GetCustomJob] or
     * other methods to check whether the cancellation succeeded or whether the
     * job completed despite cancellation. On successful cancellation,
     * the CustomJob is not deleted; instead it becomes a job with
     * a [CustomJob.error][google.cloud.aiplatform.v1.CustomJob.error] value with a [google.rpc.Status.code][google.rpc.Status.code] of 1,
     * corresponding to `Code.CANCELLED`, and [CustomJob.state][google.cloud.aiplatform.v1.CustomJob.state] is set to
     * `CANCELLED`.
     * @param \Google\Cloud\AIPlatform\V1\CancelCustomJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelCustomJob(\Google\Cloud\AIPlatform\V1\CancelCustomJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CancelCustomJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a DataLabelingJob.
     * @param \Google\Cloud\AIPlatform\V1\CreateDataLabelingJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataLabelingJob(\Google\Cloud\AIPlatform\V1\CreateDataLabelingJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CreateDataLabelingJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\DataLabelingJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a DataLabelingJob.
     * @param \Google\Cloud\AIPlatform\V1\GetDataLabelingJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataLabelingJob(\Google\Cloud\AIPlatform\V1\GetDataLabelingJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/GetDataLabelingJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\DataLabelingJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DataLabelingJobs in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListDataLabelingJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataLabelingJobs(\Google\Cloud\AIPlatform\V1\ListDataLabelingJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/ListDataLabelingJobs',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListDataLabelingJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a DataLabelingJob.
     * @param \Google\Cloud\AIPlatform\V1\DeleteDataLabelingJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataLabelingJob(\Google\Cloud\AIPlatform\V1\DeleteDataLabelingJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/DeleteDataLabelingJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a DataLabelingJob. Success of cancellation is not guaranteed.
     * @param \Google\Cloud\AIPlatform\V1\CancelDataLabelingJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelDataLabelingJob(\Google\Cloud\AIPlatform\V1\CancelDataLabelingJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CancelDataLabelingJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a HyperparameterTuningJob
     * @param \Google\Cloud\AIPlatform\V1\CreateHyperparameterTuningJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateHyperparameterTuningJob(\Google\Cloud\AIPlatform\V1\CreateHyperparameterTuningJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CreateHyperparameterTuningJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\HyperparameterTuningJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a HyperparameterTuningJob
     * @param \Google\Cloud\AIPlatform\V1\GetHyperparameterTuningJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetHyperparameterTuningJob(\Google\Cloud\AIPlatform\V1\GetHyperparameterTuningJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/GetHyperparameterTuningJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\HyperparameterTuningJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists HyperparameterTuningJobs in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListHyperparameterTuningJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListHyperparameterTuningJobs(\Google\Cloud\AIPlatform\V1\ListHyperparameterTuningJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/ListHyperparameterTuningJobs',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListHyperparameterTuningJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a HyperparameterTuningJob.
     * @param \Google\Cloud\AIPlatform\V1\DeleteHyperparameterTuningJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteHyperparameterTuningJob(\Google\Cloud\AIPlatform\V1\DeleteHyperparameterTuningJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/DeleteHyperparameterTuningJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a HyperparameterTuningJob.
     * Starts asynchronous cancellation on the HyperparameterTuningJob. The server
     * makes a best effort to cancel the job, but success is not
     * guaranteed. Clients can use [JobService.GetHyperparameterTuningJob][google.cloud.aiplatform.v1.JobService.GetHyperparameterTuningJob] or
     * other methods to check whether the cancellation succeeded or whether the
     * job completed despite cancellation. On successful cancellation,
     * the HyperparameterTuningJob is not deleted; instead it becomes a job with
     * a [HyperparameterTuningJob.error][google.cloud.aiplatform.v1.HyperparameterTuningJob.error] value with a [google.rpc.Status.code][google.rpc.Status.code]
     * of 1, corresponding to `Code.CANCELLED`, and
     * [HyperparameterTuningJob.state][google.cloud.aiplatform.v1.HyperparameterTuningJob.state] is set to `CANCELLED`.
     * @param \Google\Cloud\AIPlatform\V1\CancelHyperparameterTuningJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelHyperparameterTuningJob(\Google\Cloud\AIPlatform\V1\CancelHyperparameterTuningJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CancelHyperparameterTuningJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a BatchPredictionJob. A BatchPredictionJob once created will
     * right away be attempted to start.
     * @param \Google\Cloud\AIPlatform\V1\CreateBatchPredictionJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBatchPredictionJob(\Google\Cloud\AIPlatform\V1\CreateBatchPredictionJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CreateBatchPredictionJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\BatchPredictionJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a BatchPredictionJob
     * @param \Google\Cloud\AIPlatform\V1\GetBatchPredictionJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBatchPredictionJob(\Google\Cloud\AIPlatform\V1\GetBatchPredictionJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/GetBatchPredictionJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\BatchPredictionJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists BatchPredictionJobs in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListBatchPredictionJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBatchPredictionJobs(\Google\Cloud\AIPlatform\V1\ListBatchPredictionJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/ListBatchPredictionJobs',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListBatchPredictionJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a BatchPredictionJob. Can only be called on jobs that already
     * finished.
     * @param \Google\Cloud\AIPlatform\V1\DeleteBatchPredictionJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBatchPredictionJob(\Google\Cloud\AIPlatform\V1\DeleteBatchPredictionJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/DeleteBatchPredictionJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Cancels a BatchPredictionJob.
     *
     * Starts asynchronous cancellation on the BatchPredictionJob. The server
     * makes the best effort to cancel the job, but success is not
     * guaranteed. Clients can use [JobService.GetBatchPredictionJob][google.cloud.aiplatform.v1.JobService.GetBatchPredictionJob] or
     * other methods to check whether the cancellation succeeded or whether the
     * job completed despite cancellation. On a successful cancellation,
     * the BatchPredictionJob is not deleted;instead its
     * [BatchPredictionJob.state][google.cloud.aiplatform.v1.BatchPredictionJob.state] is set to `CANCELLED`. Any files already
     * outputted by the job are not deleted.
     * @param \Google\Cloud\AIPlatform\V1\CancelBatchPredictionJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelBatchPredictionJob(\Google\Cloud\AIPlatform\V1\CancelBatchPredictionJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CancelBatchPredictionJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a ModelDeploymentMonitoringJob. It will run periodically on a
     * configured interval.
     * @param \Google\Cloud\AIPlatform\V1\CreateModelDeploymentMonitoringJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateModelDeploymentMonitoringJob(\Google\Cloud\AIPlatform\V1\CreateModelDeploymentMonitoringJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/CreateModelDeploymentMonitoringJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches Model Monitoring Statistics generated within a given time window.
     * @param \Google\Cloud\AIPlatform\V1\SearchModelDeploymentMonitoringStatsAnomaliesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchModelDeploymentMonitoringStatsAnomalies(\Google\Cloud\AIPlatform\V1\SearchModelDeploymentMonitoringStatsAnomaliesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/SearchModelDeploymentMonitoringStatsAnomalies',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\SearchModelDeploymentMonitoringStatsAnomaliesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ModelDeploymentMonitoringJob.
     * @param \Google\Cloud\AIPlatform\V1\GetModelDeploymentMonitoringJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetModelDeploymentMonitoringJob(\Google\Cloud\AIPlatform\V1\GetModelDeploymentMonitoringJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/GetModelDeploymentMonitoringJob',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ModelDeploymentMonitoringJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ModelDeploymentMonitoringJobs in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListModelDeploymentMonitoringJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListModelDeploymentMonitoringJobs(\Google\Cloud\AIPlatform\V1\ListModelDeploymentMonitoringJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/ListModelDeploymentMonitoringJobs',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListModelDeploymentMonitoringJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a ModelDeploymentMonitoringJob.
     * @param \Google\Cloud\AIPlatform\V1\UpdateModelDeploymentMonitoringJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateModelDeploymentMonitoringJob(\Google\Cloud\AIPlatform\V1\UpdateModelDeploymentMonitoringJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/UpdateModelDeploymentMonitoringJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a ModelDeploymentMonitoringJob.
     * @param \Google\Cloud\AIPlatform\V1\DeleteModelDeploymentMonitoringJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteModelDeploymentMonitoringJob(\Google\Cloud\AIPlatform\V1\DeleteModelDeploymentMonitoringJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/DeleteModelDeploymentMonitoringJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses a ModelDeploymentMonitoringJob. If the job is running, the server
     * makes a best effort to cancel the job. Will mark
     * [ModelDeploymentMonitoringJob.state][google.cloud.aiplatform.v1.ModelDeploymentMonitoringJob.state] to 'PAUSED'.
     * @param \Google\Cloud\AIPlatform\V1\PauseModelDeploymentMonitoringJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseModelDeploymentMonitoringJob(\Google\Cloud\AIPlatform\V1\PauseModelDeploymentMonitoringJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/PauseModelDeploymentMonitoringJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Resumes a paused ModelDeploymentMonitoringJob. It will start to run from
     * next scheduled time. A deleted ModelDeploymentMonitoringJob can't be
     * resumed.
     * @param \Google\Cloud\AIPlatform\V1\ResumeModelDeploymentMonitoringJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeModelDeploymentMonitoringJob(\Google\Cloud\AIPlatform\V1\ResumeModelDeploymentMonitoringJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.JobService/ResumeModelDeploymentMonitoringJob',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
