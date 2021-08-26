<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC.
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
namespace Google\Cloud\PolicyTroubleshooter\V1;

/**
 * IAM Policy Troubleshooter service.
 *
 * This service helps you troubleshoot access issues for Google Cloud resources.
 */
class IamCheckerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Checks whether a member has a specific permission for a specific resource,
     * and explains why the member does or does not have that permission.
     * @param \Google\Cloud\PolicyTroubleshooter\V1\TroubleshootIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TroubleshootIamPolicy(\Google\Cloud\PolicyTroubleshooter\V1\TroubleshootIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.policytroubleshooter.v1.IamChecker/TroubleshootIamPolicy',
        $argument,
        ['\Google\Cloud\PolicyTroubleshooter\V1\TroubleshootIamPolicyResponse', 'decode'],
        $metadata, $options);
    }

}
