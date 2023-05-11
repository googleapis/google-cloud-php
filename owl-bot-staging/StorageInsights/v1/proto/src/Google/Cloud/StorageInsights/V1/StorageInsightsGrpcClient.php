<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2023 Google LLC
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
namespace Google\Cloud\StorageInsights\V1;

/**
 * Service describing handlers for resources
 */
class StorageInsightsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists ReportConfigs in a given project and location.
     * @param \Google\Cloud\StorageInsights\V1\ListReportConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListReportConfigs(\Google\Cloud\StorageInsights\V1\ListReportConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.storageinsights.v1.StorageInsights/ListReportConfigs',
        $argument,
        ['\Google\Cloud\StorageInsights\V1\ListReportConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single ReportConfig.
     * @param \Google\Cloud\StorageInsights\V1\GetReportConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetReportConfig(\Google\Cloud\StorageInsights\V1\GetReportConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.storageinsights.v1.StorageInsights/GetReportConfig',
        $argument,
        ['\Google\Cloud\StorageInsights\V1\ReportConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new ReportConfig in a given project and location.
     * @param \Google\Cloud\StorageInsights\V1\CreateReportConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateReportConfig(\Google\Cloud\StorageInsights\V1\CreateReportConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.storageinsights.v1.StorageInsights/CreateReportConfig',
        $argument,
        ['\Google\Cloud\StorageInsights\V1\ReportConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single ReportConfig.
     * @param \Google\Cloud\StorageInsights\V1\UpdateReportConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateReportConfig(\Google\Cloud\StorageInsights\V1\UpdateReportConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.storageinsights.v1.StorageInsights/UpdateReportConfig',
        $argument,
        ['\Google\Cloud\StorageInsights\V1\ReportConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single ReportConfig.
     * @param \Google\Cloud\StorageInsights\V1\DeleteReportConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteReportConfig(\Google\Cloud\StorageInsights\V1\DeleteReportConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.storageinsights.v1.StorageInsights/DeleteReportConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ReportDetails in a given project and location.
     * @param \Google\Cloud\StorageInsights\V1\ListReportDetailsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListReportDetails(\Google\Cloud\StorageInsights\V1\ListReportDetailsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.storageinsights.v1.StorageInsights/ListReportDetails',
        $argument,
        ['\Google\Cloud\StorageInsights\V1\ListReportDetailsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single ReportDetail.
     * @param \Google\Cloud\StorageInsights\V1\GetReportDetailRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetReportDetail(\Google\Cloud\StorageInsights\V1\GetReportDetailRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.storageinsights.v1.StorageInsights/GetReportDetail',
        $argument,
        ['\Google\Cloud\StorageInsights\V1\ReportDetail', 'decode'],
        $metadata, $options);
    }

}
