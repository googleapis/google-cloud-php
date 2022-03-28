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
 * TensorboardService
 */
class TensorboardServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a Tensorboard.
     * @param \Google\Cloud\AIPlatform\V1\CreateTensorboardRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTensorboard(\Google\Cloud\AIPlatform\V1\CreateTensorboardRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboard',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a Tensorboard.
     * @param \Google\Cloud\AIPlatform\V1\GetTensorboardRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTensorboard(\Google\Cloud\AIPlatform\V1\GetTensorboardRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboard',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\Tensorboard', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a Tensorboard.
     * @param \Google\Cloud\AIPlatform\V1\UpdateTensorboardRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTensorboard(\Google\Cloud\AIPlatform\V1\UpdateTensorboardRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboard',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Tensorboards in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListTensorboardsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTensorboards(\Google\Cloud\AIPlatform\V1\ListTensorboardsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboards',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListTensorboardsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Tensorboard.
     * @param \Google\Cloud\AIPlatform\V1\DeleteTensorboardRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTensorboard(\Google\Cloud\AIPlatform\V1\DeleteTensorboardRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboard',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a TensorboardExperiment.
     * @param \Google\Cloud\AIPlatform\V1\CreateTensorboardExperimentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTensorboardExperiment(\Google\Cloud\AIPlatform\V1\CreateTensorboardExperimentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboardExperiment',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardExperiment', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a TensorboardExperiment.
     * @param \Google\Cloud\AIPlatform\V1\GetTensorboardExperimentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTensorboardExperiment(\Google\Cloud\AIPlatform\V1\GetTensorboardExperimentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboardExperiment',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardExperiment', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a TensorboardExperiment.
     * @param \Google\Cloud\AIPlatform\V1\UpdateTensorboardExperimentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTensorboardExperiment(\Google\Cloud\AIPlatform\V1\UpdateTensorboardExperimentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboardExperiment',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardExperiment', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists TensorboardExperiments in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListTensorboardExperimentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTensorboardExperiments(\Google\Cloud\AIPlatform\V1\ListTensorboardExperimentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboardExperiments',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListTensorboardExperimentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TensorboardExperiment.
     * @param \Google\Cloud\AIPlatform\V1\DeleteTensorboardExperimentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTensorboardExperiment(\Google\Cloud\AIPlatform\V1\DeleteTensorboardExperimentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboardExperiment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a TensorboardRun.
     * @param \Google\Cloud\AIPlatform\V1\CreateTensorboardRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTensorboardRun(\Google\Cloud\AIPlatform\V1\CreateTensorboardRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboardRun',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Batch create TensorboardRuns.
     * @param \Google\Cloud\AIPlatform\V1\BatchCreateTensorboardRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateTensorboardRuns(\Google\Cloud\AIPlatform\V1\BatchCreateTensorboardRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/BatchCreateTensorboardRuns',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\BatchCreateTensorboardRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a TensorboardRun.
     * @param \Google\Cloud\AIPlatform\V1\GetTensorboardRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTensorboardRun(\Google\Cloud\AIPlatform\V1\GetTensorboardRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboardRun',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a TensorboardRun.
     * @param \Google\Cloud\AIPlatform\V1\UpdateTensorboardRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTensorboardRun(\Google\Cloud\AIPlatform\V1\UpdateTensorboardRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboardRun',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists TensorboardRuns in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListTensorboardRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTensorboardRuns(\Google\Cloud\AIPlatform\V1\ListTensorboardRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboardRuns',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListTensorboardRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TensorboardRun.
     * @param \Google\Cloud\AIPlatform\V1\DeleteTensorboardRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTensorboardRun(\Google\Cloud\AIPlatform\V1\DeleteTensorboardRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboardRun',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Batch create TensorboardTimeSeries that belong to a TensorboardExperiment.
     * @param \Google\Cloud\AIPlatform\V1\BatchCreateTensorboardTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateTensorboardTimeSeries(\Google\Cloud\AIPlatform\V1\BatchCreateTensorboardTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/BatchCreateTensorboardTimeSeries',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\BatchCreateTensorboardTimeSeriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a TensorboardTimeSeries.
     * @param \Google\Cloud\AIPlatform\V1\CreateTensorboardTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTensorboardTimeSeries(\Google\Cloud\AIPlatform\V1\CreateTensorboardTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/CreateTensorboardTimeSeries',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardTimeSeries', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a TensorboardTimeSeries.
     * @param \Google\Cloud\AIPlatform\V1\GetTensorboardTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTensorboardTimeSeries(\Google\Cloud\AIPlatform\V1\GetTensorboardTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/GetTensorboardTimeSeries',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardTimeSeries', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a TensorboardTimeSeries.
     * @param \Google\Cloud\AIPlatform\V1\UpdateTensorboardTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTensorboardTimeSeries(\Google\Cloud\AIPlatform\V1\UpdateTensorboardTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/UpdateTensorboardTimeSeries',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\TensorboardTimeSeries', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists TensorboardTimeSeries in a Location.
     * @param \Google\Cloud\AIPlatform\V1\ListTensorboardTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTensorboardTimeSeries(\Google\Cloud\AIPlatform\V1\ListTensorboardTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/ListTensorboardTimeSeries',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ListTensorboardTimeSeriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TensorboardTimeSeries.
     * @param \Google\Cloud\AIPlatform\V1\DeleteTensorboardTimeSeriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTensorboardTimeSeries(\Google\Cloud\AIPlatform\V1\DeleteTensorboardTimeSeriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/DeleteTensorboardTimeSeries',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Reads multiple TensorboardTimeSeries' data. The data point number limit is
     * 1000 for scalars, 100 for tensors and blob references. If the number of
     * data points stored is less than the limit, all data will be returned.
     * Otherwise, that limit number of data points will be randomly selected from
     * this time series and returned.
     * @param \Google\Cloud\AIPlatform\V1\BatchReadTensorboardTimeSeriesDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchReadTensorboardTimeSeriesData(\Google\Cloud\AIPlatform\V1\BatchReadTensorboardTimeSeriesDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/BatchReadTensorboardTimeSeriesData',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\BatchReadTensorboardTimeSeriesDataResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Reads a TensorboardTimeSeries' data. By default, if the number of data
     * points stored is less than 1000, all data will be returned. Otherwise, 1000
     * data points will be randomly selected from this time series and returned.
     * This value can be changed by changing max_data_points, which can't be
     * greater than 10k.
     * @param \Google\Cloud\AIPlatform\V1\ReadTensorboardTimeSeriesDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReadTensorboardTimeSeriesData(\Google\Cloud\AIPlatform\V1\ReadTensorboardTimeSeriesDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/ReadTensorboardTimeSeriesData',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ReadTensorboardTimeSeriesDataResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets bytes of TensorboardBlobs.
     * This is to allow reading blob data stored in consumer project's Cloud
     * Storage bucket without users having to obtain Cloud Storage access
     * permission.
     * @param \Google\Cloud\AIPlatform\V1\ReadTensorboardBlobDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\ServerStreamingCall
     */
    public function ReadTensorboardBlobData(\Google\Cloud\AIPlatform\V1\ReadTensorboardBlobDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_serverStreamRequest('/google.cloud.aiplatform.v1.TensorboardService/ReadTensorboardBlobData',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ReadTensorboardBlobDataResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Write time series data points of multiple TensorboardTimeSeries in multiple
     * TensorboardRun's. If any data fail to be ingested, an error will be
     * returned.
     * @param \Google\Cloud\AIPlatform\V1\WriteTensorboardExperimentDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function WriteTensorboardExperimentData(\Google\Cloud\AIPlatform\V1\WriteTensorboardExperimentDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/WriteTensorboardExperimentData',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\WriteTensorboardExperimentDataResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Write time series data points into multiple TensorboardTimeSeries under
     * a TensorboardRun. If any data fail to be ingested, an error will be
     * returned.
     * @param \Google\Cloud\AIPlatform\V1\WriteTensorboardRunDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function WriteTensorboardRunData(\Google\Cloud\AIPlatform\V1\WriteTensorboardRunDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/WriteTensorboardRunData',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\WriteTensorboardRunDataResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports a TensorboardTimeSeries' data. Data is returned in paginated
     * responses.
     * @param \Google\Cloud\AIPlatform\V1\ExportTensorboardTimeSeriesDataRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ExportTensorboardTimeSeriesData(\Google\Cloud\AIPlatform\V1\ExportTensorboardTimeSeriesDataRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.aiplatform.v1.TensorboardService/ExportTensorboardTimeSeriesData',
        $argument,
        ['\Google\Cloud\AIPlatform\V1\ExportTensorboardTimeSeriesDataResponse', 'decode'],
        $metadata, $options);
    }

}
