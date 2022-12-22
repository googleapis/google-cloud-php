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
namespace Google\Cloud\OsLogin\V1;

/**
 * Cloud OS Login API
 *
 * The Cloud OS Login API allows you to manage users and their associated SSH
 * public keys for logging into virtual machines on Google Cloud Platform.
 */
class OsLoginServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create an SSH public key
     * @param \Google\Cloud\OsLogin\V1\CreateSshPublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSshPublicKey(\Google\Cloud\OsLogin\V1\CreateSshPublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.oslogin.v1.OsLoginService/CreateSshPublicKey',
        $argument,
        ['\Google\Cloud\OsLogin\Common\SshPublicKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a POSIX account.
     * @param \Google\Cloud\OsLogin\V1\DeletePosixAccountRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePosixAccount(\Google\Cloud\OsLogin\V1\DeletePosixAccountRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.oslogin.v1.OsLoginService/DeletePosixAccount',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an SSH public key.
     * @param \Google\Cloud\OsLogin\V1\DeleteSshPublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSshPublicKey(\Google\Cloud\OsLogin\V1\DeleteSshPublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.oslogin.v1.OsLoginService/DeleteSshPublicKey',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves the profile information used for logging in to a virtual machine
     * on Google Compute Engine.
     * @param \Google\Cloud\OsLogin\V1\GetLoginProfileRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetLoginProfile(\Google\Cloud\OsLogin\V1\GetLoginProfileRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.oslogin.v1.OsLoginService/GetLoginProfile',
        $argument,
        ['\Google\Cloud\OsLogin\V1\LoginProfile', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves an SSH public key.
     * @param \Google\Cloud\OsLogin\V1\GetSshPublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSshPublicKey(\Google\Cloud\OsLogin\V1\GetSshPublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.oslogin.v1.OsLoginService/GetSshPublicKey',
        $argument,
        ['\Google\Cloud\OsLogin\Common\SshPublicKey', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds an SSH public key and returns the profile information. Default POSIX
     * account information is set when no username and UID exist as part of the
     * login profile.
     * @param \Google\Cloud\OsLogin\V1\ImportSshPublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ImportSshPublicKey(\Google\Cloud\OsLogin\V1\ImportSshPublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.oslogin.v1.OsLoginService/ImportSshPublicKey',
        $argument,
        ['\Google\Cloud\OsLogin\V1\ImportSshPublicKeyResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an SSH public key and returns the profile information. This method
     * supports patch semantics.
     * @param \Google\Cloud\OsLogin\V1\UpdateSshPublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSshPublicKey(\Google\Cloud\OsLogin\V1\UpdateSshPublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.oslogin.v1.OsLoginService/UpdateSshPublicKey',
        $argument,
        ['\Google\Cloud\OsLogin\Common\SshPublicKey', 'decode'],
        $metadata, $options);
    }

}
