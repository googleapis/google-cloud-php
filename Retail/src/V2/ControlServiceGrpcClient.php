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
namespace Google\Cloud\Retail\V2;

/**
 * Service for modifying Control.
 */
class ControlServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a Control.
     *
     * If the [Control][google.cloud.retail.v2.Control] to create already exists,
     * an ALREADY_EXISTS error is returned.
     * @param \Google\Cloud\Retail\V2\CreateControlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateControl(\Google\Cloud\Retail\V2\CreateControlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ControlService/CreateControl',
        $argument,
        ['\Google\Cloud\Retail\V2\Control', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Control.
     *
     * If the [Control][google.cloud.retail.v2.Control] to delete does not exist,
     * a NOT_FOUND error is returned.
     * @param \Google\Cloud\Retail\V2\DeleteControlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteControl(\Google\Cloud\Retail\V2\DeleteControlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ControlService/DeleteControl',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a Control.
     *
     * [Control][google.cloud.retail.v2.Control] cannot be set to a different
     * oneof field, if so an INVALID_ARGUMENT is returned. If the
     * [Control][google.cloud.retail.v2.Control] to update does not exist, a
     * NOT_FOUND error is returned.
     * @param \Google\Cloud\Retail\V2\UpdateControlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateControl(\Google\Cloud\Retail\V2\UpdateControlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ControlService/UpdateControl',
        $argument,
        ['\Google\Cloud\Retail\V2\Control', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a Control.
     * @param \Google\Cloud\Retail\V2\GetControlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetControl(\Google\Cloud\Retail\V2\GetControlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ControlService/GetControl',
        $argument,
        ['\Google\Cloud\Retail\V2\Control', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all Controls by their parent
     * [Catalog][google.cloud.retail.v2.Catalog].
     * @param \Google\Cloud\Retail\V2\ListControlsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListControls(\Google\Cloud\Retail\V2\ListControlsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ControlService/ListControls',
        $argument,
        ['\Google\Cloud\Retail\V2\ListControlsResponse', 'decode'],
        $metadata, $options);
    }

}
