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
namespace Google\Cloud\NetworkSecurity\V1beta1;

/**
 * Network Security API provides resources to configure authentication and
 * authorization policies. Refer to per API resource documentation for more
 * information.
 */
class NetworkSecurityGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists AuthorizationPolicies in a given project and location.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\ListAuthorizationPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAuthorizationPolicies(\Google\Cloud\NetworkSecurity\V1beta1\ListAuthorizationPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/ListAuthorizationPolicies',
        $argument,
        ['\Google\Cloud\NetworkSecurity\V1beta1\ListAuthorizationPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single AuthorizationPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\GetAuthorizationPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAuthorizationPolicy(\Google\Cloud\NetworkSecurity\V1beta1\GetAuthorizationPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/GetAuthorizationPolicy',
        $argument,
        ['\Google\Cloud\NetworkSecurity\V1beta1\AuthorizationPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new AuthorizationPolicy in a given project and location.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\CreateAuthorizationPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAuthorizationPolicy(\Google\Cloud\NetworkSecurity\V1beta1\CreateAuthorizationPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/CreateAuthorizationPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single AuthorizationPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\UpdateAuthorizationPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAuthorizationPolicy(\Google\Cloud\NetworkSecurity\V1beta1\UpdateAuthorizationPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/UpdateAuthorizationPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single AuthorizationPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\DeleteAuthorizationPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAuthorizationPolicy(\Google\Cloud\NetworkSecurity\V1beta1\DeleteAuthorizationPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/DeleteAuthorizationPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ServerTlsPolicies in a given project and location.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\ListServerTlsPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServerTlsPolicies(\Google\Cloud\NetworkSecurity\V1beta1\ListServerTlsPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/ListServerTlsPolicies',
        $argument,
        ['\Google\Cloud\NetworkSecurity\V1beta1\ListServerTlsPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single ServerTlsPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\GetServerTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetServerTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\GetServerTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/GetServerTlsPolicy',
        $argument,
        ['\Google\Cloud\NetworkSecurity\V1beta1\ServerTlsPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new ServerTlsPolicy in a given project and location.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\CreateServerTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateServerTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\CreateServerTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/CreateServerTlsPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single ServerTlsPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\UpdateServerTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateServerTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\UpdateServerTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/UpdateServerTlsPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single ServerTlsPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\DeleteServerTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteServerTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\DeleteServerTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/DeleteServerTlsPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists ClientTlsPolicies in a given project and location.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\ListClientTlsPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListClientTlsPolicies(\Google\Cloud\NetworkSecurity\V1beta1\ListClientTlsPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/ListClientTlsPolicies',
        $argument,
        ['\Google\Cloud\NetworkSecurity\V1beta1\ListClientTlsPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single ClientTlsPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\GetClientTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetClientTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\GetClientTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/GetClientTlsPolicy',
        $argument,
        ['\Google\Cloud\NetworkSecurity\V1beta1\ClientTlsPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new ClientTlsPolicy in a given project and location.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\CreateClientTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateClientTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\CreateClientTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/CreateClientTlsPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single ClientTlsPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\UpdateClientTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateClientTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\UpdateClientTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/UpdateClientTlsPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single ClientTlsPolicy.
     * @param \Google\Cloud\NetworkSecurity\V1beta1\DeleteClientTlsPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteClientTlsPolicy(\Google\Cloud\NetworkSecurity\V1beta1\DeleteClientTlsPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networksecurity.v1beta1.NetworkSecurity/DeleteClientTlsPolicy',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
