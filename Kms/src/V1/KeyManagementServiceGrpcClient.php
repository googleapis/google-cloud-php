<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2018 Google LLC
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
namespace Google\Cloud\Kms\V1;

/**
 * Google Cloud Key Management Service
 *
 * Manages cryptographic keys and operations using those keys. Implements a REST
 * model with the following objects:
 *
 * * [KeyRing][google.cloud.kms.v1.KeyRing]
 * * [CryptoKey][google.cloud.kms.v1.CryptoKey]
 * * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]
 * * [ImportJob][google.cloud.kms.v1.ImportJob]
 *
 * If you are using manual gRPC libraries, see
 * [Using gRPC with Cloud KMS](https://cloud.google.com/kms/docs/grpc).
 */
class KeyManagementServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists [KeyRings][google.cloud.kms.v1.KeyRing].
     * @param \Google\Cloud\Kms\V1\ListKeyRingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListKeyRings(\Google\Cloud\Kms\V1\ListKeyRingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/ListKeyRings',
        $argument,
        ['\Google\Cloud\Kms\V1\ListKeyRingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CryptoKeys][google.cloud.kms.v1.CryptoKey].
     * @param \Google\Cloud\Kms\V1\ListCryptoKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCryptoKeys(\Google\Cloud\Kms\V1\ListCryptoKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/ListCryptoKeys',
        $argument,
        ['\Google\Cloud\Kms\V1\ListCryptoKeysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion].
     * @param \Google\Cloud\Kms\V1\ListCryptoKeyVersionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCryptoKeyVersions(\Google\Cloud\Kms\V1\ListCryptoKeyVersionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/ListCryptoKeyVersions',
        $argument,
        ['\Google\Cloud\Kms\V1\ListCryptoKeyVersionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists [ImportJobs][google.cloud.kms.v1.ImportJob].
     * @param \Google\Cloud\Kms\V1\ListImportJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListImportJobs(\Google\Cloud\Kms\V1\ListImportJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/ListImportJobs',
        $argument,
        ['\Google\Cloud\Kms\V1\ListImportJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns metadata for a given [KeyRing][google.cloud.kms.v1.KeyRing].
     * @param \Google\Cloud\Kms\V1\GetKeyRingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetKeyRing(\Google\Cloud\Kms\V1\GetKeyRingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/GetKeyRing',
        $argument,
        ['\Google\Cloud\Kms\V1\KeyRing', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns metadata for a given [CryptoKey][google.cloud.kms.v1.CryptoKey], as
     * well as its [primary][google.cloud.kms.v1.CryptoKey.primary]
     * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion].
     * @param \Google\Cloud\Kms\V1\GetCryptoKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCryptoKey(\Google\Cloud\Kms\V1\GetCryptoKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/GetCryptoKey',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns metadata for a given
     * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion].
     * @param \Google\Cloud\Kms\V1\GetCryptoKeyVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCryptoKeyVersion(\Google\Cloud\Kms\V1\GetCryptoKeyVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/GetCryptoKeyVersion',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKeyVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the public key for the given
     * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]. The
     * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] must be
     * [ASYMMETRIC_SIGN][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ASYMMETRIC_SIGN]
     * or
     * [ASYMMETRIC_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ASYMMETRIC_DECRYPT].
     * @param \Google\Cloud\Kms\V1\GetPublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPublicKey(\Google\Cloud\Kms\V1\GetPublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/GetPublicKey',
        $argument,
        ['\Google\Cloud\Kms\V1\PublicKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns metadata for a given [ImportJob][google.cloud.kms.v1.ImportJob].
     * @param \Google\Cloud\Kms\V1\GetImportJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetImportJob(\Google\Cloud\Kms\V1\GetImportJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/GetImportJob',
        $argument,
        ['\Google\Cloud\Kms\V1\ImportJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new [KeyRing][google.cloud.kms.v1.KeyRing] in a given Project and
     * Location.
     * @param \Google\Cloud\Kms\V1\CreateKeyRingRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateKeyRing(\Google\Cloud\Kms\V1\CreateKeyRingRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/CreateKeyRing',
        $argument,
        ['\Google\Cloud\Kms\V1\KeyRing', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new [CryptoKey][google.cloud.kms.v1.CryptoKey] within a
     * [KeyRing][google.cloud.kms.v1.KeyRing].
     *
     * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] and
     * [CryptoKey.version_template.algorithm][google.cloud.kms.v1.CryptoKeyVersionTemplate.algorithm]
     * are required.
     * @param \Google\Cloud\Kms\V1\CreateCryptoKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCryptoKey(\Google\Cloud\Kms\V1\CreateCryptoKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/CreateCryptoKey',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] in a
     * [CryptoKey][google.cloud.kms.v1.CryptoKey].
     *
     * The server will assign the next sequential id. If unset,
     * [state][google.cloud.kms.v1.CryptoKeyVersion.state] will be set to
     * [ENABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.ENABLED].
     * @param \Google\Cloud\Kms\V1\CreateCryptoKeyVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCryptoKeyVersion(\Google\Cloud\Kms\V1\CreateCryptoKeyVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/CreateCryptoKeyVersion',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKeyVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Import wrapped key material into a
     * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion].
     *
     * All requests must specify a [CryptoKey][google.cloud.kms.v1.CryptoKey]. If
     * a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] is additionally
     * specified in the request, key material will be reimported into that
     * version. Otherwise, a new version will be created, and will be assigned the
     * next sequential id within the [CryptoKey][google.cloud.kms.v1.CryptoKey].
     * @param \Google\Cloud\Kms\V1\ImportCryptoKeyVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportCryptoKeyVersion(\Google\Cloud\Kms\V1\ImportCryptoKeyVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/ImportCryptoKeyVersion',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKeyVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a new [ImportJob][google.cloud.kms.v1.ImportJob] within a
     * [KeyRing][google.cloud.kms.v1.KeyRing].
     *
     * [ImportJob.import_method][google.cloud.kms.v1.ImportJob.import_method] is
     * required.
     * @param \Google\Cloud\Kms\V1\CreateImportJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateImportJob(\Google\Cloud\Kms\V1\CreateImportJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/CreateImportJob',
        $argument,
        ['\Google\Cloud\Kms\V1\ImportJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CryptoKey][google.cloud.kms.v1.CryptoKey].
     * @param \Google\Cloud\Kms\V1\UpdateCryptoKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCryptoKey(\Google\Cloud\Kms\V1\UpdateCryptoKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/UpdateCryptoKey',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Update a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]'s
     * metadata.
     *
     * [state][google.cloud.kms.v1.CryptoKeyVersion.state] may be changed between
     * [ENABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.ENABLED]
     * and
     * [DISABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DISABLED]
     * using this method. See
     * [DestroyCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.DestroyCryptoKeyVersion]
     * and
     * [RestoreCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.RestoreCryptoKeyVersion]
     * to move between other states.
     * @param \Google\Cloud\Kms\V1\UpdateCryptoKeyVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCryptoKeyVersion(\Google\Cloud\Kms\V1\UpdateCryptoKeyVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/UpdateCryptoKeyVersion',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKeyVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Update the version of a [CryptoKey][google.cloud.kms.v1.CryptoKey] that
     * will be used in
     * [Encrypt][google.cloud.kms.v1.KeyManagementService.Encrypt].
     *
     * Returns an error if called on a key whose purpose is not
     * [ENCRYPT_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ENCRYPT_DECRYPT].
     * @param \Google\Cloud\Kms\V1\UpdateCryptoKeyPrimaryVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCryptoKeyPrimaryVersion(\Google\Cloud\Kms\V1\UpdateCryptoKeyPrimaryVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/UpdateCryptoKeyPrimaryVersion',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Schedule a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] for
     * destruction.
     *
     * Upon calling this method,
     * [CryptoKeyVersion.state][google.cloud.kms.v1.CryptoKeyVersion.state] will
     * be set to
     * [DESTROY_SCHEDULED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROY_SCHEDULED],
     * and [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] will
     * be set to the time
     * [destroy_scheduled_duration][google.cloud.kms.v1.CryptoKey.destroy_scheduled_duration]
     * in the future. At that time, the
     * [state][google.cloud.kms.v1.CryptoKeyVersion.state] will automatically
     * change to
     * [DESTROYED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROYED],
     * and the key material will be irrevocably destroyed.
     *
     * Before the
     * [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] is
     * reached,
     * [RestoreCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.RestoreCryptoKeyVersion]
     * may be called to reverse the process.
     * @param \Google\Cloud\Kms\V1\DestroyCryptoKeyVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DestroyCryptoKeyVersion(\Google\Cloud\Kms\V1\DestroyCryptoKeyVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/DestroyCryptoKeyVersion',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKeyVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Restore a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] in the
     * [DESTROY_SCHEDULED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROY_SCHEDULED]
     * state.
     *
     * Upon restoration of the CryptoKeyVersion,
     * [state][google.cloud.kms.v1.CryptoKeyVersion.state] will be set to
     * [DISABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DISABLED],
     * and [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] will
     * be cleared.
     * @param \Google\Cloud\Kms\V1\RestoreCryptoKeyVersionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreCryptoKeyVersion(\Google\Cloud\Kms\V1\RestoreCryptoKeyVersionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/RestoreCryptoKeyVersion',
        $argument,
        ['\Google\Cloud\Kms\V1\CryptoKeyVersion', 'decode'],
        $metadata, $options);
    }

    /**
     * Encrypts data, so that it can only be recovered by a call to
     * [Decrypt][google.cloud.kms.v1.KeyManagementService.Decrypt]. The
     * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] must be
     * [ENCRYPT_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ENCRYPT_DECRYPT].
     * @param \Google\Cloud\Kms\V1\EncryptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Encrypt(\Google\Cloud\Kms\V1\EncryptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/Encrypt',
        $argument,
        ['\Google\Cloud\Kms\V1\EncryptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Decrypts data that was protected by
     * [Encrypt][google.cloud.kms.v1.KeyManagementService.Encrypt]. The
     * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] must be
     * [ENCRYPT_DECRYPT][google.cloud.kms.v1.CryptoKey.CryptoKeyPurpose.ENCRYPT_DECRYPT].
     * @param \Google\Cloud\Kms\V1\DecryptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Decrypt(\Google\Cloud\Kms\V1\DecryptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/Decrypt',
        $argument,
        ['\Google\Cloud\Kms\V1\DecryptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Signs data using a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]
     * with [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose]
     * ASYMMETRIC_SIGN, producing a signature that can be verified with the public
     * key retrieved from
     * [GetPublicKey][google.cloud.kms.v1.KeyManagementService.GetPublicKey].
     * @param \Google\Cloud\Kms\V1\AsymmetricSignRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AsymmetricSign(\Google\Cloud\Kms\V1\AsymmetricSignRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/AsymmetricSign',
        $argument,
        ['\Google\Cloud\Kms\V1\AsymmetricSignResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Decrypts data that was encrypted with a public key retrieved from
     * [GetPublicKey][google.cloud.kms.v1.KeyManagementService.GetPublicKey]
     * corresponding to a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]
     * with [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose]
     * ASYMMETRIC_DECRYPT.
     * @param \Google\Cloud\Kms\V1\AsymmetricDecryptRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AsymmetricDecrypt(\Google\Cloud\Kms\V1\AsymmetricDecryptRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/AsymmetricDecrypt',
        $argument,
        ['\Google\Cloud\Kms\V1\AsymmetricDecryptResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Signs data using a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]
     * with [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] MAC,
     * producing a tag that can be verified by another source with the same key.
     * @param \Google\Cloud\Kms\V1\MacSignRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MacSign(\Google\Cloud\Kms\V1\MacSignRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/MacSign',
        $argument,
        ['\Google\Cloud\Kms\V1\MacSignResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Verifies MAC tag using a
     * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with
     * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] MAC, and returns
     * a response that indicates whether or not the verification was successful.
     * @param \Google\Cloud\Kms\V1\MacVerifyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function MacVerify(\Google\Cloud\Kms\V1\MacVerifyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/MacVerify',
        $argument,
        ['\Google\Cloud\Kms\V1\MacVerifyResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Generate random bytes using the Cloud KMS randomness source in the provided
     * location.
     * @param \Google\Cloud\Kms\V1\GenerateRandomBytesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateRandomBytes(\Google\Cloud\Kms\V1\GenerateRandomBytesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.kms.v1.KeyManagementService/GenerateRandomBytes',
        $argument,
        ['\Google\Cloud\Kms\V1\GenerateRandomBytesResponse', 'decode'],
        $metadata, $options);
    }

}
