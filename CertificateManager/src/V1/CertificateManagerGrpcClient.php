<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\CertificateManager\V1;

/**
 * API Overview
 *
 * Certificates Manager API allows customers to see and manage all their TLS
 * certificates.
 *
 * Certificates Manager API service provides methods to manage certificates,
 * group them into collections, and create serving configuration that can be
 * easily applied to other Cloud resources e.g. Target Proxies.
 *
 * Data Model
 *
 * The Certificates Manager service exposes the following resources:
 *
 * * `Certificate` which describes a single TLS certificate.
 * * `CertificateMap` which describes a collection of certificates that can be
 * attached to a target resource.
 * * `CertificateMapEntry` which describes a single configuration entry that
 * consists of a SNI and a group of certificates. It's a subresource of
 * CertificateMap.
 *
 * Certificate, CertificateMap and CertificateMapEntry IDs
 * have to match "^[a-z0-9-]{1,63}$ regexp, which means that
 * - only lower case letters, digits, and hyphen are allowed
 * - length of the resource ID has to be in [1,63] range.
 *
 * Provides methods to manage Cloud Certificate Manager entities.
 */
class CertificateManagerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Certificates in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\ListCertificatesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificates(\Google\Cloud\CertificateManager\V1\ListCertificatesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/ListCertificates',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\ListCertificatesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Certificate.
     * @param \Google\Cloud\CertificateManager\V1\GetCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificate(\Google\Cloud\CertificateManager\V1\GetCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/GetCertificate',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\Certificate', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Certificate in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\CreateCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificate(\Google\Cloud\CertificateManager\V1\CreateCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/CreateCertificate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a Certificate.
     * @param \Google\Cloud\CertificateManager\V1\UpdateCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificate(\Google\Cloud\CertificateManager\V1\UpdateCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/UpdateCertificate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Certificate.
     * @param \Google\Cloud\CertificateManager\V1\DeleteCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCertificate(\Google\Cloud\CertificateManager\V1\DeleteCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/DeleteCertificate',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CertificateMaps in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\ListCertificateMapsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateMaps(\Google\Cloud\CertificateManager\V1\ListCertificateMapsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/ListCertificateMaps',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\ListCertificateMapsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single CertificateMap.
     * @param \Google\Cloud\CertificateManager\V1\GetCertificateMapRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateMap(\Google\Cloud\CertificateManager\V1\GetCertificateMapRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/GetCertificateMap',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\CertificateMap', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new CertificateMap in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\CreateCertificateMapRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificateMap(\Google\Cloud\CertificateManager\V1\CreateCertificateMapRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/CreateCertificateMap',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a CertificateMap.
     * @param \Google\Cloud\CertificateManager\V1\UpdateCertificateMapRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificateMap(\Google\Cloud\CertificateManager\V1\UpdateCertificateMapRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/UpdateCertificateMap',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single CertificateMap. A Certificate Map can't be deleted
     * if it contains Certificate Map Entries. Remove all the entries from
     * the map before calling this method.
     * @param \Google\Cloud\CertificateManager\V1\DeleteCertificateMapRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCertificateMap(\Google\Cloud\CertificateManager\V1\DeleteCertificateMapRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/DeleteCertificateMap',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CertificateMapEntries in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\ListCertificateMapEntriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateMapEntries(\Google\Cloud\CertificateManager\V1\ListCertificateMapEntriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/ListCertificateMapEntries',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\ListCertificateMapEntriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single CertificateMapEntry.
     * @param \Google\Cloud\CertificateManager\V1\GetCertificateMapEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateMapEntry(\Google\Cloud\CertificateManager\V1\GetCertificateMapEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/GetCertificateMapEntry',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\CertificateMapEntry', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new CertificateMapEntry in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\CreateCertificateMapEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificateMapEntry(\Google\Cloud\CertificateManager\V1\CreateCertificateMapEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/CreateCertificateMapEntry',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a CertificateMapEntry.
     * @param \Google\Cloud\CertificateManager\V1\UpdateCertificateMapEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCertificateMapEntry(\Google\Cloud\CertificateManager\V1\UpdateCertificateMapEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/UpdateCertificateMapEntry',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single CertificateMapEntry.
     * @param \Google\Cloud\CertificateManager\V1\DeleteCertificateMapEntryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCertificateMapEntry(\Google\Cloud\CertificateManager\V1\DeleteCertificateMapEntryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/DeleteCertificateMapEntry',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DnsAuthorizations in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\ListDnsAuthorizationsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDnsAuthorizations(\Google\Cloud\CertificateManager\V1\ListDnsAuthorizationsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/ListDnsAuthorizations',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\ListDnsAuthorizationsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single DnsAuthorization.
     * @param \Google\Cloud\CertificateManager\V1\GetDnsAuthorizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDnsAuthorization(\Google\Cloud\CertificateManager\V1\GetDnsAuthorizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/GetDnsAuthorization',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\DnsAuthorization', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new DnsAuthorization in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\CreateDnsAuthorizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDnsAuthorization(\Google\Cloud\CertificateManager\V1\CreateDnsAuthorizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/CreateDnsAuthorization',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a DnsAuthorization.
     * @param \Google\Cloud\CertificateManager\V1\UpdateDnsAuthorizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateDnsAuthorization(\Google\Cloud\CertificateManager\V1\UpdateDnsAuthorizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/UpdateDnsAuthorization',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single DnsAuthorization.
     * @param \Google\Cloud\CertificateManager\V1\DeleteDnsAuthorizationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDnsAuthorization(\Google\Cloud\CertificateManager\V1\DeleteDnsAuthorizationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/DeleteDnsAuthorization',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CertificateIssuanceConfigs in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\ListCertificateIssuanceConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCertificateIssuanceConfigs(\Google\Cloud\CertificateManager\V1\ListCertificateIssuanceConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/ListCertificateIssuanceConfigs',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\ListCertificateIssuanceConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single CertificateIssuanceConfig.
     * @param \Google\Cloud\CertificateManager\V1\GetCertificateIssuanceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCertificateIssuanceConfig(\Google\Cloud\CertificateManager\V1\GetCertificateIssuanceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/GetCertificateIssuanceConfig',
        $argument,
        ['\Google\Cloud\CertificateManager\V1\CertificateIssuanceConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new CertificateIssuanceConfig in a given project and location.
     * @param \Google\Cloud\CertificateManager\V1\CreateCertificateIssuanceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCertificateIssuanceConfig(\Google\Cloud\CertificateManager\V1\CreateCertificateIssuanceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/CreateCertificateIssuanceConfig',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single CertificateIssuanceConfig.
     * @param \Google\Cloud\CertificateManager\V1\DeleteCertificateIssuanceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCertificateIssuanceConfig(\Google\Cloud\CertificateManager\V1\DeleteCertificateIssuanceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.certificatemanager.v1.CertificateManager/DeleteCertificateIssuanceConfig',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
