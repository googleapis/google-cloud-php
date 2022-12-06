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
namespace Google\Cloud\Billing\V1;

/**
 * A catalog of Google Cloud Platform services and SKUs.
 * Provides pricing information and metadata on Google Cloud Platform services
 * and SKUs.
 */
class CloudCatalogGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all public cloud services.
     * @param \Google\Cloud\Billing\V1\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\Billing\V1\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudCatalog/ListServices',
        $argument,
        ['\Google\Cloud\Billing\V1\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all publicly available SKUs for a given cloud service.
     * @param \Google\Cloud\Billing\V1\ListSkusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSkus(\Google\Cloud\Billing\V1\ListSkusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.billing.v1.CloudCatalog/ListSkus',
        $argument,
        ['\Google\Cloud\Billing\V1\ListSkusResponse', 'decode'],
        $metadata, $options);
    }

}
