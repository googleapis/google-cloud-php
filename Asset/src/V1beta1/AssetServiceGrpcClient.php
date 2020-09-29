<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC.
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
namespace Google\Cloud\Asset\V1beta1;

/**
 * Asset service definition.
 */
class AssetServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Exports assets with time and resource types to a given Cloud Storage
     * location. The output format is newline-delimited JSON.
     * This API implements the
     * [google.longrunning.Operation][google.longrunning.Operation] API allowing
     * you to keep track of the export.
     * @param \Google\Cloud\Asset\V1beta1\ExportAssetsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\LongRunning\Operation
     */
    public function ExportAssets(\Google\Cloud\Asset\V1beta1\ExportAssetsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1beta1.AssetService/ExportAssets',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Batch gets the update history of assets that overlap a time window.
     * For RESOURCE content, this API outputs history with asset in both
     * non-delete or deleted status.
     * For IAM_POLICY content, this API outputs history when the asset and its
     * attached IAM POLICY both exist. This can create gaps in the output history.
     * If a specified asset does not exist, this API returns an INVALID_ARGUMENT
     * error.
     * @param \Google\Cloud\Asset\V1beta1\BatchGetAssetsHistoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Google\Cloud\Asset\V1beta1\BatchGetAssetsHistoryResponse
     */
    public function BatchGetAssetsHistory(\Google\Cloud\Asset\V1beta1\BatchGetAssetsHistoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.asset.v1beta1.AssetService/BatchGetAssetsHistory',
        $argument,
        ['\Google\Cloud\Asset\V1beta1\BatchGetAssetsHistoryResponse', 'decode'],
        $metadata, $options);
    }

}
