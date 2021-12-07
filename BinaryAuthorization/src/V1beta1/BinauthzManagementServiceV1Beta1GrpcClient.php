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
 * Customer-facing API for Cloud Binary Authorization.
 *
 * Google Cloud Management Service for Binary Authorization admission policies
 * and attestation authorities.
 *
 * This API implements a REST model with the following objects:
 *
 * * [Policy][google.cloud.binaryauthorization.v1beta1.Policy]
 * * [Attestor][google.cloud.binaryauthorization.v1beta1.Attestor]
 */
class BinauthzManagementServiceV1Beta1GrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * A [policy][google.cloud.binaryauthorization.v1beta1.Policy] specifies the [attestors][google.cloud.binaryauthorization.v1beta1.Attestor] that must attest to
     * a container image, before the project is allowed to deploy that
     * image. There is at most one policy per project. All image admission
     * requests are permitted if a project has no policy.
     *
     * Gets the [policy][google.cloud.binaryauthorization.v1beta1.Policy] for this project. Returns a default
     * [policy][google.cloud.binaryauthorization.v1beta1.Policy] if the project does not have one.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\GetPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPolicy(\Google\Cloud\BinaryAuthorization\V1beta1\GetPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1/GetPolicy',
        $argument,
        ['\Google\Cloud\BinaryAuthorization\V1beta1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates or updates a project's [policy][google.cloud.binaryauthorization.v1beta1.Policy], and returns a copy of the
     * new [policy][google.cloud.binaryauthorization.v1beta1.Policy]. A policy is always updated as a whole, to avoid race
     * conditions with concurrent policy enforcement (or management!)
     * requests. Returns NOT_FOUND if the project does not exist, INVALID_ARGUMENT
     * if the request is malformed.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\UpdatePolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdatePolicy(\Google\Cloud\BinaryAuthorization\V1beta1\UpdatePolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1/UpdatePolicy',
        $argument,
        ['\Google\Cloud\BinaryAuthorization\V1beta1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an [attestor][google.cloud.binaryauthorization.v1beta1.Attestor], and returns a copy of the new
     * [attestor][google.cloud.binaryauthorization.v1beta1.Attestor]. Returns NOT_FOUND if the project does not exist,
     * INVALID_ARGUMENT if the request is malformed, ALREADY_EXISTS if the
     * [attestor][google.cloud.binaryauthorization.v1beta1.Attestor] already exists.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\CreateAttestorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAttestor(\Google\Cloud\BinaryAuthorization\V1beta1\CreateAttestorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1/CreateAttestor',
        $argument,
        ['\Google\Cloud\BinaryAuthorization\V1beta1\Attestor', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an [attestor][google.cloud.binaryauthorization.v1beta1.Attestor].
     * Returns NOT_FOUND if the [attestor][google.cloud.binaryauthorization.v1beta1.Attestor] does not exist.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\GetAttestorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAttestor(\Google\Cloud\BinaryAuthorization\V1beta1\GetAttestorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1/GetAttestor',
        $argument,
        ['\Google\Cloud\BinaryAuthorization\V1beta1\Attestor', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an [attestor][google.cloud.binaryauthorization.v1beta1.Attestor].
     * Returns NOT_FOUND if the [attestor][google.cloud.binaryauthorization.v1beta1.Attestor] does not exist.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\UpdateAttestorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAttestor(\Google\Cloud\BinaryAuthorization\V1beta1\UpdateAttestorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1/UpdateAttestor',
        $argument,
        ['\Google\Cloud\BinaryAuthorization\V1beta1\Attestor', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [attestors][google.cloud.binaryauthorization.v1beta1.Attestor].
     * Returns INVALID_ARGUMENT if the project does not exist.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\ListAttestorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAttestors(\Google\Cloud\BinaryAuthorization\V1beta1\ListAttestorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1/ListAttestors',
        $argument,
        ['\Google\Cloud\BinaryAuthorization\V1beta1\ListAttestorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an [attestor][google.cloud.binaryauthorization.v1beta1.Attestor]. Returns NOT_FOUND if the
     * [attestor][google.cloud.binaryauthorization.v1beta1.Attestor] does not exist.
     * @param \Google\Cloud\BinaryAuthorization\V1beta1\DeleteAttestorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAttestor(\Google\Cloud\BinaryAuthorization\V1beta1\DeleteAttestorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.binaryauthorization.v1beta1.BinauthzManagementServiceV1Beta1/DeleteAttestor',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
