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
namespace Google\Cloud\Iap\V1;

/**
 * APIs for Identity-Aware Proxy Admin configurations.
 */
class IdentityAwareProxyAdminServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Sets the access control policy for an Identity-Aware Proxy protected
     * resource. Replaces any existing policy.
     * More information about managing access via IAP can be found at:
     * https://cloud.google.com/iap/docs/managing-access#managing_access_via_the_api
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the access control policy for an Identity-Aware Proxy protected
     * resource.
     * More information about managing access via IAP can be found at:
     * https://cloud.google.com/iap/docs/managing-access#managing_access_via_the_api
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns permissions that a caller has on the Identity-Aware Proxy protected
     * resource.
     * More information about managing access via IAP can be found at:
     * https://cloud.google.com/iap/docs/managing-access#managing_access_via_the_api
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAP settings on a particular IAP protected resource.
     * @param \Google\Cloud\Iap\V1\GetIapSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIapSettings(\Google\Cloud\Iap\V1\GetIapSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/GetIapSettings',
        $argument,
        ['\Google\Cloud\Iap\V1\IapSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the IAP settings on a particular IAP protected resource. It
     * replaces all fields unless the `update_mask` is set.
     * @param \Google\Cloud\Iap\V1\UpdateIapSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateIapSettings(\Google\Cloud\Iap\V1\UpdateIapSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/UpdateIapSettings',
        $argument,
        ['\Google\Cloud\Iap\V1\IapSettings', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the existing TunnelDestGroups. To group across all locations, use a
     * `-` as the location ID. For example:
     * `/v1/projects/123/iap_tunnel/locations/-/destGroups`
     * @param \Google\Cloud\Iap\V1\ListTunnelDestGroupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTunnelDestGroups(\Google\Cloud\Iap\V1\ListTunnelDestGroupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/ListTunnelDestGroups',
        $argument,
        ['\Google\Cloud\Iap\V1\ListTunnelDestGroupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new TunnelDestGroup.
     * @param \Google\Cloud\Iap\V1\CreateTunnelDestGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTunnelDestGroup(\Google\Cloud\Iap\V1\CreateTunnelDestGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/CreateTunnelDestGroup',
        $argument,
        ['\Google\Cloud\Iap\V1\TunnelDestGroup', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves an existing TunnelDestGroup.
     * @param \Google\Cloud\Iap\V1\GetTunnelDestGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTunnelDestGroup(\Google\Cloud\Iap\V1\GetTunnelDestGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/GetTunnelDestGroup',
        $argument,
        ['\Google\Cloud\Iap\V1\TunnelDestGroup', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a TunnelDestGroup.
     * @param \Google\Cloud\Iap\V1\DeleteTunnelDestGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTunnelDestGroup(\Google\Cloud\Iap\V1\DeleteTunnelDestGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/DeleteTunnelDestGroup',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a TunnelDestGroup.
     * @param \Google\Cloud\Iap\V1\UpdateTunnelDestGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTunnelDestGroup(\Google\Cloud\Iap\V1\UpdateTunnelDestGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.iap.v1.IdentityAwareProxyAdminService/UpdateTunnelDestGroup',
        $argument,
        ['\Google\Cloud\Iap\V1\TunnelDestGroup', 'decode'],
        $metadata, $options);
    }

}
