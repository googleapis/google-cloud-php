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
 * Provides a cross-region view of all Cloud KMS keys in a given Cloud project.
 */
class KeyDashboardServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Returns cryptographic keys managed by Cloud KMS in a given Cloud project.
     * Note that this data is sourced from snapshots, meaning it may not
     * completely reflect the actual state of key metadata at call time.
     * @param \Google\Cloud\Kms\Inventory\V1\ListCryptoKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCryptoKeys(\Google\Cloud\Kms\Inventory\V1\ListCryptoKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.inventory.v1.KeyDashboardService/ListCryptoKeys',
        $argument,
        ['\Google\Cloud\Kms\Inventory\V1\ListCryptoKeysResponse', 'decode'],
        $metadata, $options);
    }

}
