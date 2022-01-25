<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC
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
namespace Google\Cloud\BinaryAuthorization\V1beta1;

/**
 * API for working with the system policy.
 */
class SystemPolicyV1Beta1GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets the current system policy in the specified location.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\GetSystemPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSystemPolicy(\Google\Cloud\BinaryAuthorization\V1beta1\GetSystemPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.SystemPolicyV1Beta1/GetSystemPolicy',
        $argument,
        ['\Google\Cloud\BinaryAuthorization\V1beta1\Policy', 'decode'],
        $metadata, $options);
    }

}
