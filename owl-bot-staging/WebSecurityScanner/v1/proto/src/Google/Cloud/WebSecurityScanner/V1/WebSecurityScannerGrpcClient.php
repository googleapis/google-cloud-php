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
namespace Google\Cloud\WebSecurityScanner\V1;

/**
 * Web Security Scanner Service identifies security vulnerabilities in web
 * applications hosted on Google Cloud. It crawls your application, and
 * attempts to exercise as many user inputs and event handlers as possible.
 */
class WebSecurityScannerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new ScanConfig.
     * @param \Google\Cloud\WebSecurityScanner\V1\CreateScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateScanConfig(\Google\Cloud\WebSecurityScanner\V1\CreateScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/CreateScanConfig',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ScanConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing ScanConfig and its child resources.
     * @param \Google\Cloud\WebSecurityScanner\V1\DeleteScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteScanConfig(\Google\Cloud\WebSecurityScanner\V1\DeleteScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/DeleteScanConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ScanConfig.
     * @param \Google\Cloud\WebSecurityScanner\V1\GetScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetScanConfig(\Google\Cloud\WebSecurityScanner\V1\GetScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/GetScanConfig',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ScanConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ScanConfigs under a given project.
     * @param \Google\Cloud\WebSecurityScanner\V1\ListScanConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListScanConfigs(\Google\Cloud\WebSecurityScanner\V1\ListScanConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListScanConfigs',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ListScanConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a ScanConfig. This method support partial update of a ScanConfig.
     * @param \Google\Cloud\WebSecurityScanner\V1\UpdateScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateScanConfig(\Google\Cloud\WebSecurityScanner\V1\UpdateScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/UpdateScanConfig',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ScanConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Start a ScanRun according to the given ScanConfig.
     * @param \Google\Cloud\WebSecurityScanner\V1\StartScanRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartScanRun(\Google\Cloud\WebSecurityScanner\V1\StartScanRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/StartScanRun',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ScanRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1\GetScanRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetScanRun(\Google\Cloud\WebSecurityScanner\V1\GetScanRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/GetScanRun',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ScanRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ScanRuns under a given ScanConfig, in descending order of ScanRun
     * stop time.
     * @param \Google\Cloud\WebSecurityScanner\V1\ListScanRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListScanRuns(\Google\Cloud\WebSecurityScanner\V1\ListScanRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListScanRuns',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ListScanRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops a ScanRun. The stopped ScanRun is returned.
     * @param \Google\Cloud\WebSecurityScanner\V1\StopScanRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopScanRun(\Google\Cloud\WebSecurityScanner\V1\StopScanRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/StopScanRun',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ScanRun', 'decode'],
        $metadata, $options);
    }

    /**
     * List CrawledUrls under a given ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1\ListCrawledUrlsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCrawledUrls(\Google\Cloud\WebSecurityScanner\V1\ListCrawledUrlsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListCrawledUrls',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ListCrawledUrlsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a Finding.
     * @param \Google\Cloud\WebSecurityScanner\V1\GetFindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFinding(\Google\Cloud\WebSecurityScanner\V1\GetFindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/GetFinding',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\Finding', 'decode'],
        $metadata, $options);
    }

    /**
     * List Findings under a given ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1\ListFindingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFindings(\Google\Cloud\WebSecurityScanner\V1\ListFindingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListFindings',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ListFindingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List all FindingTypeStats under a given ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1\ListFindingTypeStatsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFindingTypeStats(\Google\Cloud\WebSecurityScanner\V1\ListFindingTypeStatsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1.WebSecurityScanner/ListFindingTypeStats',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1\ListFindingTypeStatsResponse', 'decode'],
        $metadata, $options);
    }

}
