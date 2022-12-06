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
namespace Google\Cloud\WebRisk\V1beta1;

/**
 * Web Risk v1beta1 API defines an interface to detect malicious URLs on your
 * website and in client applications.
 */
class WebRiskServiceV1Beta1GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets the most recent threat list diffs.
     * @param \Google\Cloud\WebRisk\V1beta1\ComputeThreatListDiffRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ComputeThreatListDiff(\Google\Cloud\WebRisk\V1beta1\ComputeThreatListDiffRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1/ComputeThreatListDiff',
        $argument,
        ['\Google\Cloud\WebRisk\V1beta1\ComputeThreatListDiffResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * This method is used to check whether a URI is on a given threatList.
     * @param \Google\Cloud\WebRisk\V1beta1\SearchUrisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchUris(\Google\Cloud\WebRisk\V1beta1\SearchUrisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1/SearchUris',
        $argument,
        ['\Google\Cloud\WebRisk\V1beta1\SearchUrisResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the full hashes that match the requested hash prefix.
     * This is used after a hash prefix is looked up in a threatList
     * and there is a match. The client side threatList only holds partial hashes
     * so the client must query this method to determine if there is a full
     * hash match of a threat.
     * @param \Google\Cloud\WebRisk\V1beta1\SearchHashesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchHashes(\Google\Cloud\WebRisk\V1beta1\SearchHashesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.webrisk.v1beta1.WebRiskServiceV1Beta1/SearchHashes',
        $argument,
        ['\Google\Cloud\WebRisk\V1beta1\SearchHashesResponse', 'decode'],
        $metadata, $options);
    }

}
