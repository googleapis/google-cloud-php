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
namespace Google\Cloud\Dataplex\V1;

/**
 * DataScanService manages DataScan resources which can be configured to run
 * various types of data scanning workload and generate enriched metadata (e.g.
 * Data Profile, Data Quality) for the data source.
 */
class DataScanServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a DataScan resource.
     * @param \Google\Cloud\Dataplex\V1\CreateDataScanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDataScan(\Google\Cloud\Dataplex\V1\CreateDataScanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/CreateDataScan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a DataScan resource.
     * @param \Google\Cloud\Dataplex\V1\UpdateDataScanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDataScan(\Google\Cloud\Dataplex\V1\UpdateDataScanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/UpdateDataScan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a DataScan resource.
     * @param \Google\Cloud\Dataplex\V1\DeleteDataScanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDataScan(\Google\Cloud\Dataplex\V1\DeleteDataScanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/DeleteDataScan',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a DataScan resource.
     * @param \Google\Cloud\Dataplex\V1\GetDataScanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataScan(\Google\Cloud\Dataplex\V1\GetDataScanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/GetDataScan',
        $argument,
        ['\Google\Cloud\Dataplex\V1\DataScan', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DataScans.
     * @param \Google\Cloud\Dataplex\V1\ListDataScansRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataScans(\Google\Cloud\Dataplex\V1\ListDataScansRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/ListDataScans',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListDataScansResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Runs an on-demand execution of a DataScan
     * @param \Google\Cloud\Dataplex\V1\RunDataScanRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RunDataScan(\Google\Cloud\Dataplex\V1\RunDataScanRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/RunDataScan',
        $argument,
        ['\Google\Cloud\Dataplex\V1\RunDataScanResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a DataScanJob resource.
     * @param \Google\Cloud\Dataplex\V1\GetDataScanJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDataScanJob(\Google\Cloud\Dataplex\V1\GetDataScanJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/GetDataScanJob',
        $argument,
        ['\Google\Cloud\Dataplex\V1\DataScanJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DataScanJobs under the given DataScan.
     * @param \Google\Cloud\Dataplex\V1\ListDataScanJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDataScanJobs(\Google\Cloud\Dataplex\V1\ListDataScanJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.dataplex.v1.DataScanService/ListDataScanJobs',
        $argument,
        ['\Google\Cloud\Dataplex\V1\ListDataScanJobsResponse', 'decode'],
        $metadata, $options);
    }

}
