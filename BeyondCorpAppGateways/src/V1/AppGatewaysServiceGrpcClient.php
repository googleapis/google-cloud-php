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
namespace Google\Cloud\BeyondCorp\AppGateways\V1;

/**
 * API Overview:
 *
 * The `beyondcorp.googleapis.com` service implements the Google Cloud
 * BeyondCorp API.
 *
 * Data Model:
 *
 * The AppGatewaysService exposes the following resources:
 *
 * * AppGateways, named as follows:
 *   `projects/{project_id}/locations/{location_id}/appGateways/{app_gateway_id}`.
 *
 * The AppGatewaysService service provides methods to manage
 * (create/read/update/delete) BeyondCorp AppGateways.
 */
class AppGatewaysServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists AppGateways in a given project and location.
     * @param \Google\Cloud\BeyondCorp\AppGateways\V1\ListAppGatewaysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAppGateways(\Google\Cloud\BeyondCorp\AppGateways\V1\ListAppGatewaysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appgateways.v1.AppGatewaysService/ListAppGateways',
        $argument,
        ['\Google\Cloud\BeyondCorp\AppGateways\V1\ListAppGatewaysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single AppGateway.
     * @param \Google\Cloud\BeyondCorp\AppGateways\V1\GetAppGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAppGateway(\Google\Cloud\BeyondCorp\AppGateways\V1\GetAppGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appgateways.v1.AppGatewaysService/GetAppGateway',
        $argument,
        ['\Google\Cloud\BeyondCorp\AppGateways\V1\AppGateway', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new AppGateway in a given project and location.
     * @param \Google\Cloud\BeyondCorp\AppGateways\V1\CreateAppGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAppGateway(\Google\Cloud\BeyondCorp\AppGateways\V1\CreateAppGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appgateways.v1.AppGatewaysService/CreateAppGateway',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single AppGateway.
     * @param \Google\Cloud\BeyondCorp\AppGateways\V1\DeleteAppGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAppGateway(\Google\Cloud\BeyondCorp\AppGateways\V1\DeleteAppGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appgateways.v1.AppGatewaysService/DeleteAppGateway',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
