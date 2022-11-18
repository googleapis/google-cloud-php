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
namespace Google\Cloud\BeyondCorp\ClientGateways\V1;

/**
 * API Overview:
 *
 * The `beyondcorp.googleapis.com` service implements the Google Cloud
 * BeyondCorp API.
 *
 * Data Model:
 *
 * The ClientGatewaysService exposes the following resources:
 *
 * * Client Gateways, named as follows:
 *   `projects/{project_id}/locations/{location_id}/clientGateways/{client_gateway_id}`.
 */
class ClientGatewaysServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists ClientGateways in a given project and location.
     * @param \Google\Cloud\BeyondCorp\ClientGateways\V1\ListClientGatewaysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListClientGateways(\Google\Cloud\BeyondCorp\ClientGateways\V1\ListClientGatewaysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientgateways.v1.ClientGatewaysService/ListClientGateways',
        $argument,
        ['\Google\Cloud\BeyondCorp\ClientGateways\V1\ListClientGatewaysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single ClientGateway.
     * @param \Google\Cloud\BeyondCorp\ClientGateways\V1\GetClientGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetClientGateway(\Google\Cloud\BeyondCorp\ClientGateways\V1\GetClientGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientgateways.v1.ClientGatewaysService/GetClientGateway',
        $argument,
        ['\Google\Cloud\BeyondCorp\ClientGateways\V1\ClientGateway', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new ClientGateway in a given project and location.
     * @param \Google\Cloud\BeyondCorp\ClientGateways\V1\CreateClientGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateClientGateway(\Google\Cloud\BeyondCorp\ClientGateways\V1\CreateClientGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientgateways.v1.ClientGatewaysService/CreateClientGateway',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single ClientGateway.
     * @param \Google\Cloud\BeyondCorp\ClientGateways\V1\DeleteClientGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteClientGateway(\Google\Cloud\BeyondCorp\ClientGateways\V1\DeleteClientGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientgateways.v1.ClientGatewaysService/DeleteClientGateway',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
