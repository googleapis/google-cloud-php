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
namespace Google\Cloud\GkeHub\V1;

/**
 * The GKE Hub service handles the registration of many Kubernetes clusters to
 * Google Cloud, and the management of multi-cluster features over those
 * clusters.
 *
 * The GKE Hub service operates on the following resources:
 *
 * * [Membership][google.cloud.gkehub.v1.Membership]
 * * [Feature][google.cloud.gkehub.v1.Feature]
 *
 * GKE Hub is currently available in the global region and all regions in
 * https://cloud.google.com/compute/docs/regions-zones. Feature is only
 * available in global region while membership is global region and all the
 * regions.
 *
 * **Membership management may be non-trivial:** it is recommended to use one
 * of the Google-provided client libraries or tools where possible when working
 * with Membership resources.
 */
class GkeHubGrpcClient extends \Grpc\BaseStub {

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
     * @param \Google\Cloud\GkeHub\V1\ListMembershipsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMemberships(\Google\Cloud\GkeHub\V1\ListMembershipsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/ListMemberships',
        $argument,
        ['\Google\Cloud\GkeHub\V1\ListMembershipsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Features in a given project and location.
     * @param \Google\Cloud\GkeHub\V1\ListFeaturesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListFeatures(\Google\Cloud\GkeHub\V1\ListFeaturesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/ListFeatures',
        $argument,
        ['\Google\Cloud\GkeHub\V1\ListFeaturesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a Membership.
     * @param \Google\Cloud\GkeHub\V1\GetMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMembership(\Google\Cloud\GkeHub\V1\GetMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/GetMembership',
        $argument,
        ['\Google\Cloud\GkeHub\V1\Membership', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Feature.
     * @param \Google\Cloud\GkeHub\V1\GetFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetFeature(\Google\Cloud\GkeHub\V1\GetFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/GetFeature',
        $argument,
        ['\Google\Cloud\GkeHub\V1\Feature', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Membership.
     *
     * **This is currently only supported for GKE clusters on Google Cloud**.
     * To register other clusters, follow the instructions at
     * https://cloud.google.com/anthos/multicluster-management/connect/registering-a-cluster.
     * @param \Google\Cloud\GkeHub\V1\CreateMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMembership(\Google\Cloud\GkeHub\V1\CreateMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/CreateMembership',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a new Feature.
     * @param \Google\Cloud\GkeHub\V1\CreateFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateFeature(\Google\Cloud\GkeHub\V1\CreateFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/CreateFeature',
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
     * @param \Google\Cloud\GkeHub\V1\DeleteMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMembership(\Google\Cloud\GkeHub\V1\DeleteMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/DeleteMembership',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a Feature.
     * @param \Google\Cloud\GkeHub\V1\DeleteFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteFeature(\Google\Cloud\GkeHub\V1\DeleteFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/DeleteFeature',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing Membership.
     * @param \Google\Cloud\GkeHub\V1\UpdateMembershipRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMembership(\Google\Cloud\GkeHub\V1\UpdateMembershipRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/UpdateMembership',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an existing Feature.
     * @param \Google\Cloud\GkeHub\V1\UpdateFeatureRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateFeature(\Google\Cloud\GkeHub\V1\UpdateFeatureRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/UpdateFeature',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates the manifest for deployment of the GKE connect agent.
     *
     * **This method is used internally by Google-provided libraries.**
     * Most clients should not need to call this method directly.
     * @param \Google\Cloud\GkeHub\V1\GenerateConnectManifestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateConnectManifest(\Google\Cloud\GkeHub\V1\GenerateConnectManifestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkehub.v1.GkeHub/GenerateConnectManifest',
        $argument,
        ['\Google\Cloud\GkeHub\V1\GenerateConnectManifestResponse', 'decode'],
        $metadata, $options);
    }

}
