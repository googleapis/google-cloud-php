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
namespace Google\Cloud\NetworkConnectivity\V1;

/**
 * Policy-Based Routing allows GCP customers to specify flexibile routing
 * policies for Layer 4 traffic traversing through the connected service.
 */
class PolicyBasedRoutingServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists PolicyBasedRoutes in a given project and location.
     * @param \Google\Cloud\NetworkConnectivity\V1\ListPolicyBasedRoutesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListPolicyBasedRoutes(\Google\Cloud\NetworkConnectivity\V1\ListPolicyBasedRoutesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkconnectivity.v1.PolicyBasedRoutingService/ListPolicyBasedRoutes',
        $argument,
        ['\Google\Cloud\NetworkConnectivity\V1\ListPolicyBasedRoutesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single PolicyBasedRoute.
     * @param \Google\Cloud\NetworkConnectivity\V1\GetPolicyBasedRouteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetPolicyBasedRoute(\Google\Cloud\NetworkConnectivity\V1\GetPolicyBasedRouteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkconnectivity.v1.PolicyBasedRoutingService/GetPolicyBasedRoute',
        $argument,
        ['\Google\Cloud\NetworkConnectivity\V1\PolicyBasedRoute', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new PolicyBasedRoute in a given project and location.
     * @param \Google\Cloud\NetworkConnectivity\V1\CreatePolicyBasedRouteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreatePolicyBasedRoute(\Google\Cloud\NetworkConnectivity\V1\CreatePolicyBasedRouteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkconnectivity.v1.PolicyBasedRoutingService/CreatePolicyBasedRoute',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single PolicyBasedRoute.
     * @param \Google\Cloud\NetworkConnectivity\V1\DeletePolicyBasedRouteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeletePolicyBasedRoute(\Google\Cloud\NetworkConnectivity\V1\DeletePolicyBasedRouteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkconnectivity.v1.PolicyBasedRoutingService/DeletePolicyBasedRoute',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
