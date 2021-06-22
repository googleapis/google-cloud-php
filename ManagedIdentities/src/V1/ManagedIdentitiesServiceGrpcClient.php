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
namespace Google\Cloud\ManagedIdentities\V1;

/**
 * API Overview
 *
 * The `managedidentites.googleapis.com` service implements the Google Cloud
 * Managed Identites API for identity services
 * (e.g. Microsoft Active Directory).
 *
 * The Managed Identities service provides methods to manage
 * (create/read/update/delete) domains, reset managed identities admin password,
 * add/remove domain controllers in GCP regions and add/remove VPC peering.
 *
 * Data Model
 *
 * The Managed Identities service exposes the following resources:
 *
 * * Locations as global, named as follows:
 *   `projects/{project_id}/locations/global`.
 *
 * * Domains, named as follows:
 *   `/projects/{project_id}/locations/global/domain/{domain_name}`.
 *
 * The `{domain_name}` refers to fully qualified domain name in the customer
 * project e.g. mydomain.myorganization.com, with the following restrictions:
 *
 *  * Must contain only lowercase letters, numbers, periods and hyphens.
 *  * Must start with a letter.
 *  * Must contain between 2-64 characters.
 *  * Must end with a number or a letter.
 *  * Must not start with period.
 *  * First segement length (mydomain form example above) shouldn't exceed
 *    15 chars.
 *  * The last segment cannot be fully numeric.
 *  * Must be unique within the customer project.
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
     * @param \Google\Cloud\ManagedIdentities\V1\CreateMicrosoftAdDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMicrosoftAdDomain(\Google\Cloud\ManagedIdentities\V1\CreateMicrosoftAdDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/CreateMicrosoftAdDomain',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resets a domain's administrator password.
     * @param \Google\Cloud\ManagedIdentities\V1\ResetAdminPasswordRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetAdminPassword(\Google\Cloud\ManagedIdentities\V1\ResetAdminPasswordRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/ResetAdminPassword',
        $argument,
        ['\Google\Cloud\ManagedIdentities\V1\ResetAdminPasswordResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists domains in a project.
     * @param \Google\Cloud\ManagedIdentities\V1\ListDomainsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDomains(\Google\Cloud\ManagedIdentities\V1\ListDomainsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/ListDomains',
        $argument,
        ['\Google\Cloud\ManagedIdentities\V1\ListDomainsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets information about a domain.
     * @param \Google\Cloud\ManagedIdentities\V1\GetDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDomain(\Google\Cloud\ManagedIdentities\V1\GetDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/GetDomain',
        $argument,
        ['\Google\Cloud\ManagedIdentities\V1\Domain', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the metadata and configuration of a domain.
     * @param \Google\Cloud\ManagedIdentities\V1\UpdateDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDomain(\Google\Cloud\ManagedIdentities\V1\UpdateDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/UpdateDomain',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a domain.
     * @param \Google\Cloud\ManagedIdentities\V1\DeleteDomainRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDomain(\Google\Cloud\ManagedIdentities\V1\DeleteDomainRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/DeleteDomain',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds an AD trust to a domain.
     * @param \Google\Cloud\ManagedIdentities\V1\AttachTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AttachTrust(\Google\Cloud\ManagedIdentities\V1\AttachTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/AttachTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the DNS conditional forwarder.
     * @param \Google\Cloud\ManagedIdentities\V1\ReconfigureTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReconfigureTrust(\Google\Cloud\ManagedIdentities\V1\ReconfigureTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/ReconfigureTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes an AD trust.
     * @param \Google\Cloud\ManagedIdentities\V1\DetachTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DetachTrust(\Google\Cloud\ManagedIdentities\V1\DetachTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/DetachTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Validates a trust state, that the target domain is reachable, and that the
     * target domain is able to accept incoming trust requests.
     * @param \Google\Cloud\ManagedIdentities\V1\ValidateTrustRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ValidateTrust(\Google\Cloud\ManagedIdentities\V1\ValidateTrustRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.managedidentities.v1.ManagedIdentitiesService/ValidateTrust',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
