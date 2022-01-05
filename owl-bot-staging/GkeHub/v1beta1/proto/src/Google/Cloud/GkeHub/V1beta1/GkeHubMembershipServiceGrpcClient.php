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
namespace Google\Cloud\GkeHub\V1beta1;

/**
 * The GKE Hub MembershipService handles the registration of many Kubernetes
 * clusters to Google Cloud, represented with the [Membership][google.cloud.gkehub.v1beta1.Membership] resource.
 *
 * GKE Hub is currently only available in the global region.
 *
 * **Membership management may be non-trivial:** it is recommended to use one
 * of the Google-provided client libraries or tools where possible when working
 * with Membership resources.
 */
class GkeHubMembershipServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Memberships in a given project and location.
     * @param \Google\Cloud\GkeHub\V1beta1\ListMembershipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMemberships(\Google\Cloud\GkeHub\V1beta1\ListMembershipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/ListMemberships',
        $argument,
        ['\Google\Cloud\GkeHub\V1beta1\ListMembershipsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a Membership.
     * @param \Google\Cloud\GkeHub\V1beta1\GetMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMembership(\Google\Cloud\GkeHub\V1beta1\GetMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/GetMembership',
        $argument,
        ['\Google\Cloud\GkeHub\V1beta1\Membership', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Membership.
     *
     * **This is currently only supported for GKE clusters on Google Cloud**.
     * To register other clusters, follow the instructions at
     * https://cloud.google.com/anthos/multicluster-management/connect/registering-a-cluster.
     * @param \Google\Cloud\GkeHub\V1beta1\CreateMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMembership(\Google\Cloud\GkeHub\V1beta1\CreateMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/CreateMembership',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a Membership.
     *
     * **This is currently only supported for GKE clusters on Google Cloud**.
     * To unregister other clusters, follow the instructions at
     * https://cloud.google.com/anthos/multicluster-management/connect/unregistering-a-cluster.
     * @param \Google\Cloud\GkeHub\V1beta1\DeleteMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMembership(\Google\Cloud\GkeHub\V1beta1\DeleteMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/DeleteMembership',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing Membership.
     * @param \Google\Cloud\GkeHub\V1beta1\UpdateMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMembership(\Google\Cloud\GkeHub\V1beta1\UpdateMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/UpdateMembership',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates the manifest for deployment of the GKE connect agent.
     *
     * **This method is used internally by Google-provided libraries.**
     * Most clients should not need to call this method directly.
     * @param \Google\Cloud\GkeHub\V1beta1\GenerateConnectManifestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateConnectManifest(\Google\Cloud\GkeHub\V1beta1\GenerateConnectManifestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/GenerateConnectManifest',
        $argument,
        ['\Google\Cloud\GkeHub\V1beta1\GenerateConnectManifestResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * ValidateExclusivity validates the state of exclusivity in the cluster.
     * The validation does not depend on an existing Hub membership resource.
     * @param \Google\Cloud\GkeHub\V1beta1\ValidateExclusivityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ValidateExclusivity(\Google\Cloud\GkeHub\V1beta1\ValidateExclusivityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/ValidateExclusivity',
        $argument,
        ['\Google\Cloud\GkeHub\V1beta1\ValidateExclusivityResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * GenerateExclusivityManifest generates the manifests to update the
     * exclusivity artifacts in the cluster if needed.
     *
     * Exclusivity artifacts include the Membership custom resource definition
     * (CRD) and the singleton Membership custom resource (CR). Combined with
     * ValidateExclusivity, exclusivity artifacts guarantee that a Kubernetes
     * cluster is only registered to a single GKE Hub.
     *
     * The Membership CRD is versioned, and may require conversion when the GKE
     * Hub API server begins serving a newer version of the CRD and
     * corresponding CR. The response will be the converted CRD and CR if there
     * are any differences between the versions.
     * @param \Google\Cloud\GkeHub\V1beta1\GenerateExclusivityManifestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateExclusivityManifest(\Google\Cloud\GkeHub\V1beta1\GenerateExclusivityManifestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1beta1.GkeHubMembershipService/GenerateExclusivityManifest',
        $argument,
        ['\Google\Cloud\GkeHub\V1beta1\GenerateExclusivityManifestResponse', 'decode'],
        $metadata, $options);
    }

}
