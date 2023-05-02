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
namespace Google\Cloud\ConfidentialComputing\V1;

/**
 * Service describing handlers for resources
 */
class ConfidentialComputingGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new Challenge in a given project and location.
     * @param \Google\Cloud\ConfidentialComputing\V1\CreateChallengeRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateChallenge(\Google\Cloud\ConfidentialComputing\V1\CreateChallengeRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.confidentialcomputing.v1.ConfidentialComputing/CreateChallenge',
        $argument,
        ['\Google\Cloud\ConfidentialComputing\V1\Challenge', 'decode'],
        $metadata, $options);
    }

    /**
     * Verifies the provided attestation info, returning a signed OIDC token.
     * @param \Google\Cloud\ConfidentialComputing\V1\VerifyAttestationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function VerifyAttestation(\Google\Cloud\ConfidentialComputing\V1\VerifyAttestationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.confidentialcomputing.v1.ConfidentialComputing/VerifyAttestation',
        $argument,
        ['\Google\Cloud\ConfidentialComputing\V1\VerifyAttestationResponse', 'decode'],
        $metadata, $options);
    }

}
