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
namespace Google\Cloud\Iam\V2;

/**
 * An interface for managing Identity and Access Management (IAM) policies.
 */
class PoliciesGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Retrieves the policies of the specified kind that are attached to a
     * resource.
     *
     * The response lists only policy metadata. In particular, policy rules are
     * omitted.
     * @param \Google\Cloud\Iam\V2\ListPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPolicies(\Google\Cloud\Iam\V2\ListPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.v2.Policies/ListPolicies',
        $argument,
        ['\Google\Cloud\Iam\V2\ListPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a policy.
     * @param \Google\Cloud\Iam\V2\GetPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPolicy(\Google\Cloud\Iam\V2\GetPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.v2.Policies/GetPolicy',
        $argument,
        ['\Google\Cloud\Iam\V2\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a policy.
     * @param \Google\Cloud\Iam\V2\CreatePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePolicy(\Google\Cloud\Iam\V2\CreatePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.v2.Policies/CreatePolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the specified policy.
     *
     * You can update only the rules and the display name for the policy.
     *
     * To update a policy, you should use a read-modify-write loop:
     *
     * 1. Use [GetPolicy][google.iam.v2.Policies.GetPolicy] to read the current version of the policy.
     * 2. Modify the policy as needed.
     * 3. Use `UpdatePolicy` to write the updated policy.
     *
     * This pattern helps prevent conflicts between concurrent updates.
     * @param \Google\Cloud\Iam\V2\UpdatePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePolicy(\Google\Cloud\Iam\V2\UpdatePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.v2.Policies/UpdatePolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a policy. This action is permanent.
     * @param \Google\Cloud\Iam\V2\DeletePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePolicy(\Google\Cloud\Iam\V2\DeletePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.iam.v2.Policies/DeletePolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
