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
namespace Google\Cloud\ApiKeys\V2;

/**
 * Manages the API keys associated with projects.
 */
class ApiKeysGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a new API key.
     *
     * NOTE: Key is a global resource; hence the only supported value for
     * location is `global`.
     * @param \Google\Cloud\ApiKeys\V2\CreateKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateKey(\Google\Cloud\ApiKeys\V2\CreateKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/CreateKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the API keys owned by a project. The key string of the API key
     * isn't included in the response.
     *
     * NOTE: Key is a global resource; hence the only supported value for
     * location is `global`.
     * @param \Google\Cloud\ApiKeys\V2\ListKeysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListKeys(\Google\Cloud\ApiKeys\V2\ListKeysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/ListKeys',
        $argument,
        ['\Google\Cloud\ApiKeys\V2\ListKeysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the metadata for an API key. The key string of the API key
     * isn't included in the response.
     *
     * NOTE: Key is a global resource; hence the only supported value for
     * location is `global`.
     * @param \Google\Cloud\ApiKeys\V2\GetKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetKey(\Google\Cloud\ApiKeys\V2\GetKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/GetKey',
        $argument,
        ['\Google\Cloud\ApiKeys\V2\Key', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the key string for an API key.
     *
     * NOTE: Key is a global resource; hence the only supported value for
     * location is `global`.
     * @param \Google\Cloud\ApiKeys\V2\GetKeyStringRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetKeyString(\Google\Cloud\ApiKeys\V2\GetKeyStringRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/GetKeyString',
        $argument,
        ['\Google\Cloud\ApiKeys\V2\GetKeyStringResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Patches the modifiable fields of an API key.
     * The key string of the API key isn't included in the response.
     *
     * NOTE: Key is a global resource; hence the only supported value for
     * location is `global`.
     * @param \Google\Cloud\ApiKeys\V2\UpdateKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateKey(\Google\Cloud\ApiKeys\V2\UpdateKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/UpdateKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an API key. Deleted key can be retrieved within 30 days of
     * deletion. Afterward, key will be purged from the project.
     *
     * NOTE: Key is a global resource; hence the only supported value for
     * location is `global`.
     * @param \Google\Cloud\ApiKeys\V2\DeleteKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteKey(\Google\Cloud\ApiKeys\V2\DeleteKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/DeleteKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Undeletes an API key which was deleted within 30 days.
     *
     * NOTE: Key is a global resource; hence the only supported value for
     * location is `global`.
     * @param \Google\Cloud\ApiKeys\V2\UndeleteKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteKey(\Google\Cloud\ApiKeys\V2\UndeleteKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/UndeleteKey',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Find the parent project and resource name of the API
     * key that matches the key string in the request. If the API key has been
     * purged, resource name will not be set.
     * The service account must have the `apikeys.keys.lookup` permission
     * on the parent project.
     * @param \Google\Cloud\ApiKeys\V2\LookupKeyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function LookupKey(\Google\Cloud\ApiKeys\V2\LookupKeyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.apikeys.v2.ApiKeys/LookupKey',
        $argument,
        ['\Google\Cloud\ApiKeys\V2\LookupKeyResponse', 'decode'],
        $metadata, $options);
    }

}
