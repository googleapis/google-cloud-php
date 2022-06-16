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
namespace Google\Cloud\ResourceManager\V3;

/**
 * Allows users to manage their organization resources.
 */
class OrganizationsGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Fetches an organization resource identified by the specified resource name.
     * @param \Google\Cloud\ResourceManager\V3\GetOrganizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOrganization(\Google\Cloud\ResourceManager\V3\GetOrganizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Organizations/GetOrganization',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\Organization', 'decode'],
        $metadata, $options);
    }

    /**
     * Searches organization resources that are visible to the user and satisfy
     * the specified filter. This method returns organizations in an unspecified
     * order. New organizations do not necessarily appear at the end of the
     * results, and may take a small amount of time to appear.
     *
     * Search will only return organizations on which the user has the permission
     * `resourcemanager.organizations.get`
     * @param \Google\Cloud\ResourceManager\V3\SearchOrganizationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SearchOrganizations(\Google\Cloud\ResourceManager\V3\SearchOrganizationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Organizations/SearchOrganizations',
        $argument,
        ['\Google\Cloud\ResourceManager\V3\SearchOrganizationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for an organization resource. The policy may
     * be empty if no such policy or resource exists. The `resource` field should
     * be the organization's resource name, for example: "organizations/123".
     *
     * Authorization requires the IAM permission
     * `resourcemanager.organizations.getIamPolicy` on the specified organization.
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Organizations/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the access control policy on an organization resource. Replaces any
     * existing policy. The `resource` field should be the organization's resource
     * name, for example: "organizations/123".
     *
     * Authorization requires the IAM permission
     * `resourcemanager.organizations.setIamPolicy` on the specified organization.
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Organizations/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the permissions that a caller has on the specified organization.
     * The `resource` field should be the organization's resource name,
     * for example: "organizations/123".
     *
     * There are no permissions required for making this API call.
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.resourcemanager.v3.Organizations/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
