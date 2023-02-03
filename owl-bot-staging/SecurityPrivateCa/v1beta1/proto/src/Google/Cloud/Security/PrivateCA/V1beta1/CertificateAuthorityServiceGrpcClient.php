<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\Security\PrivateCA\V1beta1;

/**
 * [Certificate Authority Service][google.cloud.security.privateca.v1beta1.CertificateAuthorityService] manages private
 * certificate authorities and issued certificates.
 */
class CertificateAuthorityServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a new [Certificate][google.cloud.security.privateca.v1beta1.Certificate] in a given Project, Location from a particular
     * [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\CreateCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificate(\Google\Cloud\Security\PrivateCA\V1beta1\CreateCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/CreateCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [Certificate][google.cloud.security.privateca.v1beta1.Certificate].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\GetCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificate(\Google\Cloud\Security\PrivateCA\V1beta1\GetCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [Certificates][google.cloud.security.privateca.v1beta1.Certificate].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\ListCertificatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificates(\Google\Cloud\Security\PrivateCA\V1beta1\ListCertificatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListCertificates',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\ListCertificatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Revoke a [Certificate][google.cloud.security.privateca.v1beta1.Certificate].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\RevokeCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RevokeCertificate(\Google\Cloud\Security\PrivateCA\V1beta1\RevokeCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/RevokeCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [Certificate][google.cloud.security.privateca.v1beta1.Certificate]. Currently, the only field you can update is the
     * [labels][google.cloud.security.privateca.v1beta1.Certificate.labels] field.
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\UpdateCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificate(\Google\Cloud\Security\PrivateCA\V1beta1\UpdateCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/UpdateCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Activate a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] that is in state
     * [PENDING_ACTIVATION][google.cloud.security.privateca.v1beta1.CertificateAuthority.State.PENDING_ACTIVATION] and is
     * of type [SUBORDINATE][google.cloud.security.privateca.v1beta1.CertificateAuthority.Type.SUBORDINATE]. After the
     * parent Certificate Authority signs a certificate signing request from
     * [FetchCertificateAuthorityCsr][google.cloud.security.privateca.v1beta1.CertificateAuthorityService.FetchCertificateAuthorityCsr], this method can complete the activation
     * process.
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\ActivateCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ActivateCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\ActivateCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ActivateCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] in a given Project and Location.
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\CreateCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\CreateCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/CreateCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Disable a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\DisableCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DisableCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\DisableCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/DisableCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Enable a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\EnableCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnableCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\EnableCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/EnableCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetch a certificate signing request (CSR) from a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority]
     * that is in state
     * [PENDING_ACTIVATION][google.cloud.security.privateca.v1beta1.CertificateAuthority.State.PENDING_ACTIVATION] and is
     * of type [SUBORDINATE][google.cloud.security.privateca.v1beta1.CertificateAuthority.Type.SUBORDINATE]. The CSR must
     * then be signed by the desired parent Certificate Authority, which could be
     * another [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] resource, or could be an on-prem
     * certificate authority. See also [ActivateCertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthorityService.ActivateCertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\FetchCertificateAuthorityCsrRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchCertificateAuthorityCsr(\Google\Cloud\Security\PrivateCA\V1beta1\FetchCertificateAuthorityCsrRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/FetchCertificateAuthorityCsr',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\FetchCertificateAuthorityCsrResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\GetCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\GetCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetCertificateAuthority',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\CertificateAuthority', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CertificateAuthorities][google.cloud.security.privateca.v1beta1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateAuthoritiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateAuthorities(\Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateAuthoritiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListCertificateAuthorities',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateAuthoritiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Restore a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] that is scheduled for deletion.
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\RestoreCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\RestoreCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/RestoreCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Schedule a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority] for deletion.
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\ScheduleDeleteCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ScheduleDeleteCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\ScheduleDeleteCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ScheduleDeleteCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CertificateAuthority][google.cloud.security.privateca.v1beta1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\UpdateCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1beta1\UpdateCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/UpdateCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [CertificateRevocationList][google.cloud.security.privateca.v1beta1.CertificateRevocationList].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\GetCertificateRevocationListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateRevocationList(\Google\Cloud\Security\PrivateCA\V1beta1\GetCertificateRevocationListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetCertificateRevocationList',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\CertificateRevocationList', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CertificateRevocationLists][google.cloud.security.privateca.v1beta1.CertificateRevocationList].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateRevocationListsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateRevocationLists(\Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateRevocationListsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListCertificateRevocationLists',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\ListCertificateRevocationListsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CertificateRevocationList][google.cloud.security.privateca.v1beta1.CertificateRevocationList].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\UpdateCertificateRevocationListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificateRevocationList(\Google\Cloud\Security\PrivateCA\V1beta1\UpdateCertificateRevocationListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/UpdateCertificateRevocationList',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [ReusableConfig][google.cloud.security.privateca.v1beta1.ReusableConfig].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\GetReusableConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetReusableConfig(\Google\Cloud\Security\PrivateCA\V1beta1\GetReusableConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/GetReusableConfig',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\ReusableConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [ReusableConfigs][google.cloud.security.privateca.v1beta1.ReusableConfig].
     * @param \Google\Cloud\Security\PrivateCA\V1beta1\ListReusableConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListReusableConfigs(\Google\Cloud\Security\PrivateCA\V1beta1\ListReusableConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1beta1.CertificateAuthorityService/ListReusableConfigs',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1beta1\ListReusableConfigsResponse', 'decode'],
        $metadata, $options);
    }

}
