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
namespace Google\Cloud\ApiGateway\V1;

/**
 * The API Gateway Service is the interface for managing API Gateways.
 */
class ApiGatewayServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Gateways in a given project and location.
     * @param \Google\Cloud\ApiGateway\V1\ListGatewaysRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGateways(\Google\Cloud\ApiGateway\V1\ListGatewaysRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/ListGateways',
        $argument,
        ['\Google\Cloud\ApiGateway\V1\ListGatewaysResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Gateway.
     * @param \Google\Cloud\ApiGateway\V1\GetGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGateway(\Google\Cloud\ApiGateway\V1\GetGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/GetGateway',
        $argument,
        ['\Google\Cloud\ApiGateway\V1\Gateway', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Gateway in a given project and location.
     * @param \Google\Cloud\ApiGateway\V1\CreateGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateGateway(\Google\Cloud\ApiGateway\V1\CreateGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/CreateGateway',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Gateway.
     * @param \Google\Cloud\ApiGateway\V1\UpdateGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGateway(\Google\Cloud\ApiGateway\V1\UpdateGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/UpdateGateway',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Gateway.
     * @param \Google\Cloud\ApiGateway\V1\DeleteGatewayRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteGateway(\Google\Cloud\ApiGateway\V1\DeleteGatewayRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/DeleteGateway',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Apis in a given project and location.
     * @param \Google\Cloud\ApiGateway\V1\ListApisRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApis(\Google\Cloud\ApiGateway\V1\ListApisRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/ListApis',
        $argument,
        ['\Google\Cloud\ApiGateway\V1\ListApisResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Api.
     * @param \Google\Cloud\ApiGateway\V1\GetApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApi(\Google\Cloud\ApiGateway\V1\GetApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/GetApi',
        $argument,
        ['\Google\Cloud\ApiGateway\V1\Api', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Api in a given project and location.
     * @param \Google\Cloud\ApiGateway\V1\CreateApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateApi(\Google\Cloud\ApiGateway\V1\CreateApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/CreateApi',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Api.
     * @param \Google\Cloud\ApiGateway\V1\UpdateApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateApi(\Google\Cloud\ApiGateway\V1\UpdateApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/UpdateApi',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Api.
     * @param \Google\Cloud\ApiGateway\V1\DeleteApiRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApi(\Google\Cloud\ApiGateway\V1\DeleteApiRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/DeleteApi',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ApiConfigs in a given project and location.
     * @param \Google\Cloud\ApiGateway\V1\ListApiConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListApiConfigs(\Google\Cloud\ApiGateway\V1\ListApiConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/ListApiConfigs',
        $argument,
        ['\Google\Cloud\ApiGateway\V1\ListApiConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single ApiConfig.
     * @param \Google\Cloud\ApiGateway\V1\GetApiConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetApiConfig(\Google\Cloud\ApiGateway\V1\GetApiConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/GetApiConfig',
        $argument,
        ['\Google\Cloud\ApiGateway\V1\ApiConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new ApiConfig in a given project and location.
     * @param \Google\Cloud\ApiGateway\V1\CreateApiConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateApiConfig(\Google\Cloud\ApiGateway\V1\CreateApiConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/CreateApiConfig',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single ApiConfig.
     * @param \Google\Cloud\ApiGateway\V1\UpdateApiConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateApiConfig(\Google\Cloud\ApiGateway\V1\UpdateApiConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/UpdateApiConfig',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single ApiConfig.
     * @param \Google\Cloud\ApiGateway\V1\DeleteApiConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteApiConfig(\Google\Cloud\ApiGateway\V1\DeleteApiConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.apigateway.v1.ApiGatewayService/DeleteApiConfig',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
