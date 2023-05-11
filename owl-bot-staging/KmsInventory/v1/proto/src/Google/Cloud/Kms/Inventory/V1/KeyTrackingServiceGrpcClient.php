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
namespace Google\Cloud\Kms\Inventory\V1;

/**
 * Returns information about the resources in an org that are protected by a
 * given Cloud KMS key via CMEK.
 */
class KeyTrackingServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns aggregate information about the resources protected by the given
     * Cloud KMS [CryptoKey][google.cloud.kms.v1.CryptoKey]. Only resources within
     * the same Cloud organization as the key will be returned. The project that
     * holds the key must be part of an organization in order for this call to
     * succeed.
     * @param \Google\Cloud\Kms\Inventory\V1\GetProtectedResourcesSummaryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetProtectedResourcesSummary(\Google\Cloud\Kms\Inventory\V1\GetProtectedResourcesSummaryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.inventory.v1.KeyTrackingService/GetProtectedResourcesSummary',
        $argument,
        ['\Google\Cloud\Kms\Inventory\V1\ProtectedResourcesSummary', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns metadata about the resources protected by the given Cloud KMS
     * [CryptoKey][google.cloud.kms.v1.CryptoKey] in the given Cloud organization.
     * @param \Google\Cloud\Kms\Inventory\V1\SearchProtectedResourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchProtectedResources(\Google\Cloud\Kms\Inventory\V1\SearchProtectedResourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.inventory.v1.KeyTrackingService/SearchProtectedResources',
        $argument,
        ['\Google\Cloud\Kms\Inventory\V1\SearchProtectedResourcesResponse', 'decode'],
        $metadata, $options);
    }

}
