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
namespace Google\Cloud\Shell\V1;

/**
 * API for interacting with Google Cloud Shell. Each user of Cloud Shell has at
 * least one environment, which has the ID "default". Environment consists of a
 * Docker image defining what is installed on the environment and a home
 * directory containing the user's data that will remain across sessions.
 * Clients use this API to start and fetch information about their environment,
 * which can then be used to connect to that environment via a separate SSH
 * client.
 */
class CloudShellServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Gets an environment. Returns NOT_FOUND if the environment does not exist.
     * @param \Google\Cloud\Shell\V1\GetEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEnvironment(\Google\Cloud\Shell\V1\GetEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.shell.v1.CloudShellService/GetEnvironment',
        $argument,
        ['\Google\Cloud\Shell\V1\Environment', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts an existing environment, allowing clients to connect to it. The
     * returned operation will contain an instance of StartEnvironmentMetadata in
     * its metadata field. Users can wait for the environment to start by polling
     * this operation via GetOperation. Once the environment has finished starting
     * and is ready to accept connections, the operation will contain a
     * StartEnvironmentResponse in its response field.
     * @param \Google\Cloud\Shell\V1\StartEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartEnvironment(\Google\Cloud\Shell\V1\StartEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.shell.v1.CloudShellService/StartEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Sends OAuth credentials to a running environment on behalf of a user. When
     * this completes, the environment will be authorized to run various Google
     * Cloud command line tools without requiring the user to manually
     * authenticate.
     * @param \Google\Cloud\Shell\V1\AuthorizeEnvironmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AuthorizeEnvironment(\Google\Cloud\Shell\V1\AuthorizeEnvironmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.shell.v1.CloudShellService/AuthorizeEnvironment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a public SSH key to an environment, allowing clients with the
     * corresponding private key to connect to that environment via SSH. If a key
     * with the same content already exists, this will error with ALREADY_EXISTS.
     * @param \Google\Cloud\Shell\V1\AddPublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddPublicKey(\Google\Cloud\Shell\V1\AddPublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.shell.v1.CloudShellService/AddPublicKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a public SSH key from an environment. Clients will no longer be
     * able to connect to the environment using the corresponding private key.
     * If a key with the same content is not present, this will error with
     * NOT_FOUND.
     * @param \Google\Cloud\Shell\V1\RemovePublicKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemovePublicKey(\Google\Cloud\Shell\V1\RemovePublicKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.shell.v1.CloudShellService/RemovePublicKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
