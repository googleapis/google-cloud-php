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
namespace Google\Cloud\WebSecurityScanner\V1beta;

/**
 * Cloud Web Security Scanner Service identifies security vulnerabilities in web
 * applications hosted on Google Cloud Platform. It crawls your application, and
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
     * @param \Google\Cloud\WebSecurityScanner\V1beta\CreateScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateScanConfig(\Google\Cloud\WebSecurityScanner\V1beta\CreateScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/CreateScanConfig',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ScanConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an existing ScanConfig and its child resources.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\DeleteScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteScanConfig(\Google\Cloud\WebSecurityScanner\V1beta\DeleteScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/DeleteScanConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ScanConfig.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\GetScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetScanConfig(\Google\Cloud\WebSecurityScanner\V1beta\GetScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/GetScanConfig',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ScanConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ScanConfigs under a given project.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\ListScanConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListScanConfigs(\Google\Cloud\WebSecurityScanner\V1beta\ListScanConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/ListScanConfigs',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ListScanConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a ScanConfig. This method support partial update of a ScanConfig.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\UpdateScanConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateScanConfig(\Google\Cloud\WebSecurityScanner\V1beta\UpdateScanConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/UpdateScanConfig',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ScanConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Start a ScanRun according to the given ScanConfig.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\StartScanRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartScanRun(\Google\Cloud\WebSecurityScanner\V1beta\StartScanRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/StartScanRun',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ScanRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\GetScanRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetScanRun(\Google\Cloud\WebSecurityScanner\V1beta\GetScanRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/GetScanRun',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ScanRun', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ScanRuns under a given ScanConfig, in descending order of ScanRun
     * stop time.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\ListScanRunsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListScanRuns(\Google\Cloud\WebSecurityScanner\V1beta\ListScanRunsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/ListScanRuns',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ListScanRunsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops a ScanRun. The stopped ScanRun is returned.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\StopScanRunRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopScanRun(\Google\Cloud\WebSecurityScanner\V1beta\StopScanRunRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/StopScanRun',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ScanRun', 'decode'],
        $metadata, $options);
    }

    /**
     * List CrawledUrls under a given ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\ListCrawledUrlsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCrawledUrls(\Google\Cloud\WebSecurityScanner\V1beta\ListCrawledUrlsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/ListCrawledUrls',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ListCrawledUrlsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a Finding.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\GetFindingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFinding(\Google\Cloud\WebSecurityScanner\V1beta\GetFindingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/GetFinding',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\Finding', 'decode'],
        $metadata, $options);
    }

    /**
     * List Findings under a given ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\ListFindingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFindings(\Google\Cloud\WebSecurityScanner\V1beta\ListFindingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/ListFindings',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ListFindingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List all FindingTypeStats under a given ScanRun.
     * @param \Google\Cloud\WebSecurityScanner\V1beta\ListFindingTypeStatsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFindingTypeStats(\Google\Cloud\WebSecurityScanner\V1beta\ListFindingTypeStatsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.websecurityscanner.v1beta.WebSecurityScanner/ListFindingTypeStats',
        $argument,
        ['\Google\Cloud\WebSecurityScanner\V1beta\ListFindingTypeStatsResponse', 'decode'],
        $metadata, $options);
    }

}
