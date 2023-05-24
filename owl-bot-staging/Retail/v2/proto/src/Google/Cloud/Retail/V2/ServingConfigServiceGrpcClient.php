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
 * Service for modifying ServingConfig.
 */
class ServingConfigServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a ServingConfig.
     *
     * A maximum of 100 [ServingConfig][google.cloud.retail.v2.ServingConfig]s are
     * allowed in a [Catalog][google.cloud.retail.v2.Catalog], otherwise a
     * FAILED_PRECONDITION error is returned.
     * @param \Google\Cloud\Retail\V2\CreateServingConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateServingConfig(\Google\Cloud\Retail\V2\CreateServingConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ServingConfigService/CreateServingConfig',
        $argument,
        ['\Google\Cloud\Retail\V2\ServingConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a ServingConfig.
     *
     * Returns a NotFound error if the ServingConfig does not exist.
     * @param \Google\Cloud\Retail\V2\DeleteServingConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteServingConfig(\Google\Cloud\Retail\V2\DeleteServingConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ServingConfigService/DeleteServingConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a ServingConfig.
     * @param \Google\Cloud\Retail\V2\UpdateServingConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateServingConfig(\Google\Cloud\Retail\V2\UpdateServingConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ServingConfigService/UpdateServingConfig',
        $argument,
        ['\Google\Cloud\Retail\V2\ServingConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a ServingConfig.
     *
     * Returns a NotFound error if the ServingConfig does not exist.
     * @param \Google\Cloud\Retail\V2\GetServingConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetServingConfig(\Google\Cloud\Retail\V2\GetServingConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ServingConfigService/GetServingConfig',
        $argument,
        ['\Google\Cloud\Retail\V2\ServingConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all ServingConfigs linked to this catalog.
     * @param \Google\Cloud\Retail\V2\ListServingConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServingConfigs(\Google\Cloud\Retail\V2\ListServingConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ServingConfigService/ListServingConfigs',
        $argument,
        ['\Google\Cloud\Retail\V2\ListServingConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables a Control on the specified ServingConfig.
     * The control is added in the last position of the list of controls
     * it belongs to (e.g. if it's a facet spec control it will be applied
     * in the last position of servingConfig.facetSpecIds)
     * Returns a ALREADY_EXISTS error if the control has already been applied.
     * Returns a FAILED_PRECONDITION error if the addition could exceed maximum
     * number of control allowed for that type of control.
     * @param \Google\Cloud\Retail\V2\AddControlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddControl(\Google\Cloud\Retail\V2\AddControlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ServingConfigService/AddControl',
        $argument,
        ['\Google\Cloud\Retail\V2\ServingConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Disables a Control on the specified ServingConfig.
     * The control is removed from the ServingConfig.
     * Returns a NOT_FOUND error if the Control is not enabled for the
     * ServingConfig.
     * @param \Google\Cloud\Retail\V2\RemoveControlRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveControl(\Google\Cloud\Retail\V2\RemoveControlRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.retail.v2.ServingConfigService/RemoveControl',
        $argument,
        ['\Google\Cloud\Retail\V2\ServingConfig', 'decode'],
        $metadata, $options);
    }

}
