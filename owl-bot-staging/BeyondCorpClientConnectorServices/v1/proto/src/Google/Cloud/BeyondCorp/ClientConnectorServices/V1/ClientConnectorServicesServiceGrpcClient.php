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
namespace Google\Cloud\BeyondCorp\ClientConnectorServices\V1;

/**
 * API Overview:
 *
 * The `beyondcorp.googleapis.com` service implements the Google Cloud
 * BeyondCorp API.
 *
 * Data Model:
 *
 * The ClientConnectorServicesService exposes the following resources:
 *
 * * Client Connector Services, named as follows:
 *   `projects/{project_id}/locations/{location_id}/client_connector_services/{client_connector_service_id}`.
 */
class ClientConnectorServicesServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists ClientConnectorServices in a given project and location.
     * @param \Google\Cloud\BeyondCorp\ClientConnectorServices\V1\ListClientConnectorServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListClientConnectorServices(\Google\Cloud\BeyondCorp\ClientConnectorServices\V1\ListClientConnectorServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientconnectorservices.v1.ClientConnectorServicesService/ListClientConnectorServices',
        $argument,
        ['\Google\Cloud\BeyondCorp\ClientConnectorServices\V1\ListClientConnectorServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single ClientConnectorService.
     * @param \Google\Cloud\BeyondCorp\ClientConnectorServices\V1\GetClientConnectorServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetClientConnectorService(\Google\Cloud\BeyondCorp\ClientConnectorServices\V1\GetClientConnectorServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientconnectorservices.v1.ClientConnectorServicesService/GetClientConnectorService',
        $argument,
        ['\Google\Cloud\BeyondCorp\ClientConnectorServices\V1\ClientConnectorService', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new ClientConnectorService in a given project and location.
     * @param \Google\Cloud\BeyondCorp\ClientConnectorServices\V1\CreateClientConnectorServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateClientConnectorService(\Google\Cloud\BeyondCorp\ClientConnectorServices\V1\CreateClientConnectorServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientconnectorservices.v1.ClientConnectorServicesService/CreateClientConnectorService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single ClientConnectorService.
     * @param \Google\Cloud\BeyondCorp\ClientConnectorServices\V1\UpdateClientConnectorServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateClientConnectorService(\Google\Cloud\BeyondCorp\ClientConnectorServices\V1\UpdateClientConnectorServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientconnectorservices.v1.ClientConnectorServicesService/UpdateClientConnectorService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single ClientConnectorService.
     * @param \Google\Cloud\BeyondCorp\ClientConnectorServices\V1\DeleteClientConnectorServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteClientConnectorService(\Google\Cloud\BeyondCorp\ClientConnectorServices\V1\DeleteClientConnectorServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.clientconnectorservices.v1.ClientConnectorServicesService/DeleteClientConnectorService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
