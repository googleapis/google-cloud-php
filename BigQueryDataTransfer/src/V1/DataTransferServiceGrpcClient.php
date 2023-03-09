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
namespace Google\Cloud\BigQuery\DataTransfer\V1;

/**
 * This API allows users to manage their data transfers into BigQuery.
 */
class DataTransferServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieves a supported data source and returns its settings.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\GetDataSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataSource(\Google\Cloud\BigQuery\DataTransfer\V1\GetDataSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/GetDataSource',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\DataSource', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists supported data sources and returns their settings.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\ListDataSourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataSources(\Google\Cloud\BigQuery\DataTransfer\V1\ListDataSourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListDataSources',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\ListDataSourcesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new data transfer configuration.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\CreateTransferConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTransferConfig(\Google\Cloud\BigQuery\DataTransfer\V1\CreateTransferConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/CreateTransferConfig',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a data transfer configuration.
     * All fields must be set, even if they are not updated.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\UpdateTransferConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTransferConfig(\Google\Cloud\BigQuery\DataTransfer\V1\UpdateTransferConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/UpdateTransferConfig',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a data transfer configuration, including any associated transfer
     * runs and logs.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTransferConfig(\Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/DeleteTransferConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about a data transfer config.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\GetTransferConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTransferConfig(\Google\Cloud\BigQuery\DataTransfer\V1\GetTransferConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/GetTransferConfig',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\TransferConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about all transfer configs owned by a project in the
     * specified location.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTransferConfigs(\Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListTransferConfigs',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\ListTransferConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates transfer runs for a time range [start_time, end_time].
     * For each date - or whatever granularity the data source supports - in the
     * range, one transfer run is created.
     * Note that runs are created per UTC time in the time range.
     * DEPRECATED: use StartManualTransferRuns instead.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ScheduleTransferRuns(\Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ScheduleTransferRuns',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\ScheduleTransferRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Start manual transfer runs to be executed now with schedule_time equal to
     * current time. The transfer runs can be created for a time range where the
     * run_time is between start_time (inclusive) and end_time (exclusive), or for
     * a specific run_time.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\StartManualTransferRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartManualTransferRuns(\Google\Cloud\BigQuery\DataTransfer\V1\StartManualTransferRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/StartManualTransferRuns',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\StartManualTransferRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about the particular transfer run.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\GetTransferRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTransferRun(\Google\Cloud\BigQuery\DataTransfer\V1\GetTransferRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/GetTransferRun',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\TransferRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes the specified transfer run.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTransferRun(\Google\Cloud\BigQuery\DataTransfer\V1\DeleteTransferRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/DeleteTransferRun',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns information about running and completed transfer runs.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTransferRuns(\Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListTransferRuns',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\ListTransferRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns log messages for the transfer run.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\ListTransferLogsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTransferLogs(\Google\Cloud\BigQuery\DataTransfer\V1\ListTransferLogsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/ListTransferLogs',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\ListTransferLogsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns true if valid credentials exist for the given data source and
     * requesting user.
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CheckValidCreds(\Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/CheckValidCreds',
        $argument,
        ['\Google\Cloud\BigQuery\DataTransfer\V1\CheckValidCredsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Enroll data sources in a user project. This allows users to create transfer
     * configurations for these data sources. They will also appear in the
     * ListDataSources RPC and as such, will appear in the
     * [BigQuery UI](https://console.cloud.google.com/bigquery), and the documents
     * can be found in the public guide for
     * [BigQuery Web UI](https://cloud.google.com/bigquery/bigquery-web-ui) and
     * [Data Transfer
     * Service](https://cloud.google.com/bigquery/docs/working-with-transfers).
     * @param \Google\Cloud\BigQuery\DataTransfer\V1\EnrollDataSourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnrollDataSources(\Google\Cloud\BigQuery\DataTransfer\V1\EnrollDataSourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.bigquery.datatransfer.v1.DataTransferService/EnrollDataSources',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
