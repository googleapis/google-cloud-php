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
namespace Google\Cloud\VpcAccess\V1;

/**
 * Serverless VPC Access API allows users to create and manage connectors for
 * App Engine, Cloud Functions and Cloud Run to have internal connections to
 * Virtual Private Cloud networks.
 */
class VpcAccessServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a Serverless VPC Access connector, returns an operation.
     * @param \Google\Cloud\VpcAccess\V1\CreateConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConnector(\Google\Cloud\VpcAccess\V1\CreateConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vpcaccess.v1.VpcAccessService/CreateConnector',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a Serverless VPC Access connector. Returns NOT_FOUND if the resource
     * does not exist.
     * @param \Google\Cloud\VpcAccess\V1\GetConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnector(\Google\Cloud\VpcAccess\V1\GetConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vpcaccess.v1.VpcAccessService/GetConnector',
        $argument,
        ['\Google\Cloud\VpcAccess\V1\Connector', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Serverless VPC Access connectors.
     * @param \Google\Cloud\VpcAccess\V1\ListConnectorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConnectors(\Google\Cloud\VpcAccess\V1\ListConnectorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vpcaccess.v1.VpcAccessService/ListConnectors',
        $argument,
        ['\Google\Cloud\VpcAccess\V1\ListConnectorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Serverless VPC Access connector. Returns NOT_FOUND if the
     * resource does not exist.
     * @param \Google\Cloud\VpcAccess\V1\DeleteConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConnector(\Google\Cloud\VpcAccess\V1\DeleteConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vpcaccess.v1.VpcAccessService/DeleteConnector',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
