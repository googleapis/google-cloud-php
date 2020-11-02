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
namespace Google\Cloud\Gaming\V1;

/**
 * A realm is a grouping of game server clusters that are considered
 * interchangeable.
 */
class RealmsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists realms in a given project and location.
     * @param \Google\Cloud\Gaming\V1\ListRealmsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListRealms(\Google\Cloud\Gaming\V1\ListRealmsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gaming.v1.RealmsService/ListRealms',
        $argument,
        ['\Google\Cloud\Gaming\V1\ListRealmsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single realm.
     * @param \Google\Cloud\Gaming\V1\GetRealmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetRealm(\Google\Cloud\Gaming\V1\GetRealmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gaming.v1.RealmsService/GetRealm',
        $argument,
        ['\Google\Cloud\Gaming\V1\Realm', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new realm in a given project and location.
     * @param \Google\Cloud\Gaming\V1\CreateRealmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateRealm(\Google\Cloud\Gaming\V1\CreateRealmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gaming.v1.RealmsService/CreateRealm',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single realm.
     * @param \Google\Cloud\Gaming\V1\DeleteRealmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteRealm(\Google\Cloud\Gaming\V1\DeleteRealmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gaming.v1.RealmsService/DeleteRealm',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Patches a single realm.
     * @param \Google\Cloud\Gaming\V1\UpdateRealmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateRealm(\Google\Cloud\Gaming\V1\UpdateRealmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gaming.v1.RealmsService/UpdateRealm',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Previews patches to a single realm.
     * @param \Google\Cloud\Gaming\V1\PreviewRealmUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PreviewRealmUpdate(\Google\Cloud\Gaming\V1\PreviewRealmUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gaming.v1.RealmsService/PreviewRealmUpdate',
        $argument,
        ['\Google\Cloud\Gaming\V1\PreviewRealmUpdateResponse', 'decode'],
        $metadata, $options);
    }

}
