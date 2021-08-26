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
namespace Google\Cloud\GkeConnect\Gateway\V1beta1;

/**
 * Gateway service is a public API which works as a Kubernetes resource model
 * proxy between end users and registered Kubernetes clusters. Each RPC in this
 * service matches with an HTTP verb. End user will initiate kubectl commands
 * against the Gateway service, and Gateway service will forward user requests
 * to clusters.
 */
class GatewayServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * GetResource performs an HTTP GET request on the Kubernetes API Server.
     * @param \Google\Api\HttpBody $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetResource(\Google\Api\HttpBody $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkeconnect.gateway.v1beta1.GatewayService/GetResource',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * PostResource performs an HTTP POST on the Kubernetes API Server.
     * @param \Google\Api\HttpBody $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PostResource(\Google\Api\HttpBody $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkeconnect.gateway.v1beta1.GatewayService/PostResource',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * DeleteResource performs an HTTP DELETE on the Kubernetes API Server.
     * @param \Google\Api\HttpBody $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteResource(\Google\Api\HttpBody $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkeconnect.gateway.v1beta1.GatewayService/DeleteResource',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * PutResource performs an HTTP PUT on the Kubernetes API Server.
     * @param \Google\Api\HttpBody $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PutResource(\Google\Api\HttpBody $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkeconnect.gateway.v1beta1.GatewayService/PutResource',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

    /**
     * PatchResource performs an HTTP PATCH on the Kubernetes API Server.
     * @param \Google\Api\HttpBody $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PatchResource(\Google\Api\HttpBody $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.gkeconnect.gateway.v1beta1.GatewayService/PatchResource',
        $argument,
        ['\Google\Api\HttpBody', 'decode'],
        $metadata, $options);
    }

}
