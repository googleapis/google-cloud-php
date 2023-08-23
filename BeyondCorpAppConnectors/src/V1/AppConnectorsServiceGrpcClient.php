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
namespace Google\Cloud\BeyondCorp\AppConnectors\V1;

/**
 * API Overview:
 *
 * The `beyondcorp.googleapis.com` service implements the Google Cloud
 * BeyondCorp API.
 *
 * Data Model:
 *
 * The AppConnectorsService exposes the following resource:
 *
 * * AppConnectors, named as follows:
 *   `projects/{project_id}/locations/{location_id}/appConnectors/{app_connector_id}`.
 *
 * The AppConnectorsService provides methods to manage
 * (create/read/update/delete) BeyondCorp AppConnectors.
 */
class AppConnectorsServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists AppConnectors in a given project and location.
     * @param \Google\Cloud\BeyondCorp\AppConnectors\V1\ListAppConnectorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAppConnectors(\Google\Cloud\BeyondCorp\AppConnectors\V1\ListAppConnectorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnectors.v1.AppConnectorsService/ListAppConnectors',
        $argument,
        ['\Google\Cloud\BeyondCorp\AppConnectors\V1\ListAppConnectorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single AppConnector.
     * @param \Google\Cloud\BeyondCorp\AppConnectors\V1\GetAppConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAppConnector(\Google\Cloud\BeyondCorp\AppConnectors\V1\GetAppConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnectors.v1.AppConnectorsService/GetAppConnector',
        $argument,
        ['\Google\Cloud\BeyondCorp\AppConnectors\V1\AppConnector', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new AppConnector in a given project and location.
     * @param \Google\Cloud\BeyondCorp\AppConnectors\V1\CreateAppConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAppConnector(\Google\Cloud\BeyondCorp\AppConnectors\V1\CreateAppConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnectors.v1.AppConnectorsService/CreateAppConnector',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single AppConnector.
     * @param \Google\Cloud\BeyondCorp\AppConnectors\V1\UpdateAppConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAppConnector(\Google\Cloud\BeyondCorp\AppConnectors\V1\UpdateAppConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnectors.v1.AppConnectorsService/UpdateAppConnector',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single AppConnector.
     * @param \Google\Cloud\BeyondCorp\AppConnectors\V1\DeleteAppConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAppConnector(\Google\Cloud\BeyondCorp\AppConnectors\V1\DeleteAppConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnectors.v1.AppConnectorsService/DeleteAppConnector',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Report status for a given connector.
     * @param \Google\Cloud\BeyondCorp\AppConnectors\V1\ReportStatusRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ReportStatus(\Google\Cloud\BeyondCorp\AppConnectors\V1\ReportStatusRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.beyondcorp.appconnectors.v1.AppConnectorsService/ReportStatus',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
