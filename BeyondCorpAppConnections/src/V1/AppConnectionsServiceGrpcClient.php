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
namespace Google\Cloud\BeyondCorp\AppConnections\V1;

/**
 * API Overview:
 *
 * The `beyondcorp.googleapis.com` service implements the Google Cloud
 * BeyondCorp API.
 *
 * Data Model:
 *
 * The AppConnectionsService exposes the following resources:
 *
 * * AppConnections, named as follows:
 *   `projects/{project_id}/locations/{location_id}/appConnections/{app_connection_id}`.
 *
 * The AppConnectionsService service provides methods to manage
 * (create/read/update/delete) BeyondCorp AppConnections.
 */
class AppConnectionsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists AppConnections in a given project and location.
     * @param \Google\Cloud\BeyondCorp\AppConnections\V1\ListAppConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAppConnections(\Google\Cloud\BeyondCorp\AppConnections\V1\ListAppConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnections.v1.AppConnectionsService/ListAppConnections',
        $argument,
        ['\Google\Cloud\BeyondCorp\AppConnections\V1\ListAppConnectionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single AppConnection.
     * @param \Google\Cloud\BeyondCorp\AppConnections\V1\GetAppConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAppConnection(\Google\Cloud\BeyondCorp\AppConnections\V1\GetAppConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnections.v1.AppConnectionsService/GetAppConnection',
        $argument,
        ['\Google\Cloud\BeyondCorp\AppConnections\V1\AppConnection', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new AppConnection in a given project and location.
     * @param \Google\Cloud\BeyondCorp\AppConnections\V1\CreateAppConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAppConnection(\Google\Cloud\BeyondCorp\AppConnections\V1\CreateAppConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnections.v1.AppConnectionsService/CreateAppConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single AppConnection.
     * @param \Google\Cloud\BeyondCorp\AppConnections\V1\UpdateAppConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAppConnection(\Google\Cloud\BeyondCorp\AppConnections\V1\UpdateAppConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnections.v1.AppConnectionsService/UpdateAppConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single AppConnection.
     * @param \Google\Cloud\BeyondCorp\AppConnections\V1\DeleteAppConnectionRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAppConnection(\Google\Cloud\BeyondCorp\AppConnections\V1\DeleteAppConnectionRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnections.v1.AppConnectionsService/DeleteAppConnection',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resolves AppConnections details for a given AppConnector.
     * An internal method called by a connector to find AppConnections to connect
     * to.
     * @param \Google\Cloud\BeyondCorp\AppConnections\V1\ResolveAppConnectionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResolveAppConnections(\Google\Cloud\BeyondCorp\AppConnections\V1\ResolveAppConnectionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnections.v1.AppConnectionsService/ResolveAppConnections',
        $argument,
        ['\Google\Cloud\BeyondCorp\AppConnections\V1\ResolveAppConnectionsResponse', 'decode'],
        $metadata, $options);
    }

}
