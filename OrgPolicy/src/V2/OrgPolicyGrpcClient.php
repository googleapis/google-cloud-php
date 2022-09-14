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
namespace Google\Cloud\OrgPolicy\V2;

/**
 * An interface for managing organization policies.
 *
 * The Cloud Org Policy service provides a simple mechanism for organizations to
 * restrict the allowed configurations across their entire Cloud Resource
 * hierarchy.
 *
 * You can use a `policy` to configure restrictions in Cloud resources. For
 * example, you can enforce a `policy` that restricts which Google
 * Cloud Platform APIs can be activated in a certain part of your resource
 * hierarchy, or prevents serial port access to VM instances in a particular
 * folder.
 *
 * `Policies` are inherited down through the resource hierarchy. A `policy`
 * applied to a parent resource automatically applies to all its child resources
 * unless overridden with a `policy` lower in the hierarchy.
 *
 * A `constraint` defines an aspect of a resource's configuration that can be
 * controlled by an organization's policy administrator. `Policies` are a
 * collection of `constraints` that defines their allowable configuration on a
 * particular resource and its child resources.
 */
class OrgPolicyGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists `Constraints` that could be applied on the specified resource.
     * @param \Google\Cloud\OrgPolicy\V2\ListConstraintsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConstraints(\Google\Cloud\OrgPolicy\V2\ListConstraintsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orgpolicy.v2.OrgPolicy/ListConstraints',
        $argument,
        ['\Google\Cloud\OrgPolicy\V2\ListConstraintsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves all of the `Policies` that exist on a particular resource.
     * @param \Google\Cloud\OrgPolicy\V2\ListPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPolicies(\Google\Cloud\OrgPolicy\V2\ListPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orgpolicy.v2.OrgPolicy/ListPolicies',
        $argument,
        ['\Google\Cloud\OrgPolicy\V2\ListPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a `Policy` on a resource.
     *
     * If no `Policy` is set on the resource, NOT_FOUND is returned. The
     * `etag` value can be used with `UpdatePolicy()` to update a
     * `Policy` during read-modify-write.
     * @param \Google\Cloud\OrgPolicy\V2\GetPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPolicy(\Google\Cloud\OrgPolicy\V2\GetPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orgpolicy.v2.OrgPolicy/GetPolicy',
        $argument,
        ['\Google\Cloud\OrgPolicy\V2\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the effective `Policy` on a resource. This is the result of merging
     * `Policies` in the resource hierarchy and evaluating conditions. The
     * returned `Policy` will not have an `etag` or `condition` set because it is
     * a computed `Policy` across multiple resources.
     * Subtrees of Resource Manager resource hierarchy with 'under:' prefix will
     * not be expanded.
     * @param \Google\Cloud\OrgPolicy\V2\GetEffectivePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEffectivePolicy(\Google\Cloud\OrgPolicy\V2\GetEffectivePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orgpolicy.v2.OrgPolicy/GetEffectivePolicy',
        $argument,
        ['\Google\Cloud\OrgPolicy\V2\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Policy.
     *
     * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
     * constraint does not exist.
     * Returns a `google.rpc.Status` with `google.rpc.Code.ALREADY_EXISTS` if the
     * policy already exists on the given Cloud resource.
     * @param \Google\Cloud\OrgPolicy\V2\CreatePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePolicy(\Google\Cloud\OrgPolicy\V2\CreatePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orgpolicy.v2.OrgPolicy/CreatePolicy',
        $argument,
        ['\Google\Cloud\OrgPolicy\V2\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a Policy.
     *
     * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
     * constraint or the policy do not exist.
     * Returns a `google.rpc.Status` with `google.rpc.Code.ABORTED` if the etag
     * supplied in the request does not match the persisted etag of the policy
     *
     * Note: the supplied policy will perform a full overwrite of all
     * fields.
     * @param \Google\Cloud\OrgPolicy\V2\UpdatePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePolicy(\Google\Cloud\OrgPolicy\V2\UpdatePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orgpolicy.v2.OrgPolicy/UpdatePolicy',
        $argument,
        ['\Google\Cloud\OrgPolicy\V2\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Policy.
     *
     * Returns a `google.rpc.Status` with `google.rpc.Code.NOT_FOUND` if the
     * constraint or Org Policy does not exist.
     * @param \Google\Cloud\OrgPolicy\V2\DeletePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePolicy(\Google\Cloud\OrgPolicy\V2\DeletePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.orgpolicy.v2.OrgPolicy/DeletePolicy',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
