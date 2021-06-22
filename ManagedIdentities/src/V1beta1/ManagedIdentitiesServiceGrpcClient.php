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
namespace Google\Cloud\ManagedIdentities\V1beta1;

/**
 */
class ManagedIdentitiesServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a Microsoft AD domain.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\CreateMicrosoftAdDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMicrosoftAdDomain(\Google\Cloud\ManagedIdentities\V1beta1\CreateMicrosoftAdDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/CreateMicrosoftAdDomain',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets a domain's administrator password.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\ResetAdminPasswordRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetAdminPassword(\Google\Cloud\ManagedIdentities\V1beta1\ResetAdminPasswordRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/ResetAdminPassword',
        $argument,
        ['\Google\Cloud\ManagedIdentities\V1beta1\ResetAdminPasswordResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists domains in a project.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\ListDomainsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDomains(\Google\Cloud\ManagedIdentities\V1beta1\ListDomainsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/ListDomains',
        $argument,
        ['\Google\Cloud\ManagedIdentities\V1beta1\ListDomainsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about a domain.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\GetDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDomain(\Google\Cloud\ManagedIdentities\V1beta1\GetDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/GetDomain',
        $argument,
        ['\Google\Cloud\ManagedIdentities\V1beta1\Domain', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the metadata and configuration of a domain.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\UpdateDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDomain(\Google\Cloud\ManagedIdentities\V1beta1\UpdateDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/UpdateDomain',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a domain.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\DeleteDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDomain(\Google\Cloud\ManagedIdentities\V1beta1\DeleteDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/DeleteDomain',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds an AD trust to a domain.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\AttachTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AttachTrust(\Google\Cloud\ManagedIdentities\V1beta1\AttachTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/AttachTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the DNS conditional forwarder.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\ReconfigureTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReconfigureTrust(\Google\Cloud\ManagedIdentities\V1beta1\ReconfigureTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/ReconfigureTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes an AD trust.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\DetachTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DetachTrust(\Google\Cloud\ManagedIdentities\V1beta1\DetachTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/DetachTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Validates a trust state, that the target domain is reachable, and that the
     * target domain is able to accept incoming trust requests.
     * @param \Google\Cloud\ManagedIdentities\V1beta1\ValidateTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ValidateTrust(\Google\Cloud\ManagedIdentities\V1beta1\ValidateTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1beta1.ManagedIdentitiesService/ValidateTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
