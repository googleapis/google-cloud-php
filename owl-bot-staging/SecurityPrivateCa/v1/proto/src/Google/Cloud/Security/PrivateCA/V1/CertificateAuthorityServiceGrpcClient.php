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
namespace Google\Cloud\Security\PrivateCA\V1;

/**
 * [Certificate Authority Service][google.cloud.security.privateca.v1.CertificateAuthorityService] manages private
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
     * Create a new [Certificate][google.cloud.security.privateca.v1.Certificate] in a given Project, Location from a particular
     * [CaPool][google.cloud.security.privateca.v1.CaPool].
     * @param \Google\Cloud\Security\PrivateCA\V1\CreateCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificate(\Google\Cloud\Security\PrivateCA\V1\CreateCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/CreateCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [Certificate][google.cloud.security.privateca.v1.Certificate].
     * @param \Google\Cloud\Security\PrivateCA\V1\GetCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificate(\Google\Cloud\Security\PrivateCA\V1\GetCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/GetCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [Certificates][google.cloud.security.privateca.v1.Certificate].
     * @param \Google\Cloud\Security\PrivateCA\V1\ListCertificatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificates(\Google\Cloud\Security\PrivateCA\V1\ListCertificatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/ListCertificates',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\ListCertificatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Revoke a [Certificate][google.cloud.security.privateca.v1.Certificate].
     * @param \Google\Cloud\Security\PrivateCA\V1\RevokeCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RevokeCertificate(\Google\Cloud\Security\PrivateCA\V1\RevokeCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/RevokeCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [Certificate][google.cloud.security.privateca.v1.Certificate]. Currently, the only field you can update is the
     * [labels][google.cloud.security.privateca.v1.Certificate.labels] field.
     * @param \Google\Cloud\Security\PrivateCA\V1\UpdateCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificate(\Google\Cloud\Security\PrivateCA\V1\UpdateCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/UpdateCertificate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Activate a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority] that is in state
     * [AWAITING_USER_ACTIVATION][google.cloud.security.privateca.v1.CertificateAuthority.State.AWAITING_USER_ACTIVATION]
     * and is of type [SUBORDINATE][google.cloud.security.privateca.v1.CertificateAuthority.Type.SUBORDINATE]. After
     * the parent Certificate Authority signs a certificate signing request from
     * [FetchCertificateAuthorityCsr][google.cloud.security.privateca.v1.CertificateAuthorityService.FetchCertificateAuthorityCsr], this method can complete the activation
     * process.
     * @param \Google\Cloud\Security\PrivateCA\V1\ActivateCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ActivateCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\ActivateCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/ActivateCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority] in a given Project and Location.
     * @param \Google\Cloud\Security\PrivateCA\V1\CreateCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\CreateCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/CreateCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Disable a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1\DisableCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DisableCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\DisableCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/DisableCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Enable a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1\EnableCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnableCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\EnableCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/EnableCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Fetch a certificate signing request (CSR) from a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority]
     * that is in state
     * [AWAITING_USER_ACTIVATION][google.cloud.security.privateca.v1.CertificateAuthority.State.AWAITING_USER_ACTIVATION]
     * and is of type [SUBORDINATE][google.cloud.security.privateca.v1.CertificateAuthority.Type.SUBORDINATE]. The
     * CSR must then be signed by the desired parent Certificate Authority, which
     * could be another [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority] resource, or could be an on-prem
     * certificate authority. See also [ActivateCertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthorityService.ActivateCertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1\FetchCertificateAuthorityCsrRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchCertificateAuthorityCsr(\Google\Cloud\Security\PrivateCA\V1\FetchCertificateAuthorityCsrRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/FetchCertificateAuthorityCsr',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\FetchCertificateAuthorityCsrResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1\GetCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\GetCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/GetCertificateAuthority',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\CertificateAuthority', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CertificateAuthorities][google.cloud.security.privateca.v1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1\ListCertificateAuthoritiesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateAuthorities(\Google\Cloud\Security\PrivateCA\V1\ListCertificateAuthoritiesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/ListCertificateAuthorities',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\ListCertificateAuthoritiesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Undelete a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority] that has been deleted.
     * @param \Google\Cloud\Security\PrivateCA\V1\UndeleteCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\UndeleteCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/UndeleteCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1\DeleteCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\DeleteCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/DeleteCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority].
     * @param \Google\Cloud\Security\PrivateCA\V1\UpdateCertificateAuthorityRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificateAuthority(\Google\Cloud\Security\PrivateCA\V1\UpdateCertificateAuthorityRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/UpdateCertificateAuthority',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a [CaPool][google.cloud.security.privateca.v1.CaPool].
     * @param \Google\Cloud\Security\PrivateCA\V1\CreateCaPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCaPool(\Google\Cloud\Security\PrivateCA\V1\CreateCaPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/CreateCaPool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CaPool][google.cloud.security.privateca.v1.CaPool].
     * @param \Google\Cloud\Security\PrivateCA\V1\UpdateCaPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCaPool(\Google\Cloud\Security\PrivateCA\V1\UpdateCaPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/UpdateCaPool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [CaPool][google.cloud.security.privateca.v1.CaPool].
     * @param \Google\Cloud\Security\PrivateCA\V1\GetCaPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCaPool(\Google\Cloud\Security\PrivateCA\V1\GetCaPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/GetCaPool',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\CaPool', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CaPools][google.cloud.security.privateca.v1.CaPool].
     * @param \Google\Cloud\Security\PrivateCA\V1\ListCaPoolsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCaPools(\Google\Cloud\Security\PrivateCA\V1\ListCaPoolsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/ListCaPools',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\ListCaPoolsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete a [CaPool][google.cloud.security.privateca.v1.CaPool].
     * @param \Google\Cloud\Security\PrivateCA\V1\DeleteCaPoolRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCaPool(\Google\Cloud\Security\PrivateCA\V1\DeleteCaPoolRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/DeleteCaPool',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * FetchCaCerts returns the current trust anchor for the [CaPool][google.cloud.security.privateca.v1.CaPool]. This will
     * include CA certificate chains for all ACTIVE [CertificateAuthority][google.cloud.security.privateca.v1.CertificateAuthority]
     * resources in the [CaPool][google.cloud.security.privateca.v1.CaPool].
     * @param \Google\Cloud\Security\PrivateCA\V1\FetchCaCertsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchCaCerts(\Google\Cloud\Security\PrivateCA\V1\FetchCaCertsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/FetchCaCerts',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\FetchCaCertsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [CertificateRevocationList][google.cloud.security.privateca.v1.CertificateRevocationList].
     * @param \Google\Cloud\Security\PrivateCA\V1\GetCertificateRevocationListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateRevocationList(\Google\Cloud\Security\PrivateCA\V1\GetCertificateRevocationListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/GetCertificateRevocationList',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\CertificateRevocationList', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CertificateRevocationLists][google.cloud.security.privateca.v1.CertificateRevocationList].
     * @param \Google\Cloud\Security\PrivateCA\V1\ListCertificateRevocationListsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateRevocationLists(\Google\Cloud\Security\PrivateCA\V1\ListCertificateRevocationListsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/ListCertificateRevocationLists',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\ListCertificateRevocationListsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CertificateRevocationList][google.cloud.security.privateca.v1.CertificateRevocationList].
     * @param \Google\Cloud\Security\PrivateCA\V1\UpdateCertificateRevocationListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificateRevocationList(\Google\Cloud\Security\PrivateCA\V1\UpdateCertificateRevocationListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/UpdateCertificateRevocationList',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate] in a given Project and Location.
     * @param \Google\Cloud\Security\PrivateCA\V1\CreateCertificateTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificateTemplate(\Google\Cloud\Security\PrivateCA\V1\CreateCertificateTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/CreateCertificateTemplate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * DeleteCertificateTemplate deletes a [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate].
     * @param \Google\Cloud\Security\PrivateCA\V1\DeleteCertificateTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCertificateTemplate(\Google\Cloud\Security\PrivateCA\V1\DeleteCertificateTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/DeleteCertificateTemplate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns a [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate].
     * @param \Google\Cloud\Security\PrivateCA\V1\GetCertificateTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateTemplate(\Google\Cloud\Security\PrivateCA\V1\GetCertificateTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/GetCertificateTemplate',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\CertificateTemplate', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CertificateTemplates][google.cloud.security.privateca.v1.CertificateTemplate].
     * @param \Google\Cloud\Security\PrivateCA\V1\ListCertificateTemplatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateTemplates(\Google\Cloud\Security\PrivateCA\V1\ListCertificateTemplatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/ListCertificateTemplates',
        $argument,
        ['\Google\Cloud\Security\PrivateCA\V1\ListCertificateTemplatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CertificateTemplate][google.cloud.security.privateca.v1.CertificateTemplate].
     * @param \Google\Cloud\Security\PrivateCA\V1\UpdateCertificateTemplateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificateTemplate(\Google\Cloud\Security\PrivateCA\V1\UpdateCertificateTemplateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.security.privateca.v1.CertificateAuthorityService/UpdateCertificateTemplate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
