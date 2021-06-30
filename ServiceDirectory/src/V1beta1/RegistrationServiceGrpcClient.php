<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2020 Google LLC
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
namespace Google\Cloud\ServiceDirectory\V1beta1;

/**
 * Service Directory API for registering services. It defines the following
 * resource model:
 *
 * - The API has a collection of
 * [Namespace][google.cloud.servicedirectory.v1beta1.Namespace]
 * resources, named `projects/&#42;/locations/&#42;/namespaces/*`.
 *
 * - Each Namespace has a collection of
 * [Service][google.cloud.servicedirectory.v1beta1.Service] resources, named
 * `projects/&#42;/locations/&#42;/namespaces/&#42;/services/*`.
 *
 * - Each Service has a collection of
 * [Endpoint][google.cloud.servicedirectory.v1beta1.Endpoint]
 * resources, named
 * `projects/&#42;/locations/&#42;/namespaces/&#42;/services/&#42;/endpoints/*`.
 */
class RegistrationServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Creates a namespace, and returns the new namespace.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\CreateNamespaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateNamespace(\Google\Cloud\ServiceDirectory\V1beta1\CreateNamespaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/CreateNamespace',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\PBNamespace', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all namespaces.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\ListNamespacesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListNamespaces(\Google\Cloud\ServiceDirectory\V1beta1\ListNamespacesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/ListNamespaces',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\ListNamespacesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a namespace.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\GetNamespaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetNamespace(\Google\Cloud\ServiceDirectory\V1beta1\GetNamespaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/GetNamespace',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\PBNamespace', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a namespace.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\UpdateNamespaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateNamespace(\Google\Cloud\ServiceDirectory\V1beta1\UpdateNamespaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/UpdateNamespace',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\PBNamespace', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a namespace. This also deletes all services and endpoints in
     * the namespace.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\DeleteNamespaceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteNamespace(\Google\Cloud\ServiceDirectory\V1beta1\DeleteNamespaceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/DeleteNamespace',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a service, and returns the new service.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\CreateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateService(\Google\Cloud\ServiceDirectory\V1beta1\CreateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/CreateService',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all services belonging to a namespace.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\ServiceDirectory\V1beta1\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/ListServices',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a service.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\GetServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetService(\Google\Cloud\ServiceDirectory\V1beta1\GetServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/GetService',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates a service.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\UpdateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateService(\Google\Cloud\ServiceDirectory\V1beta1\UpdateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/UpdateService',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a service. This also deletes all endpoints associated with
     * the service.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\DeleteServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteService(\Google\Cloud\ServiceDirectory\V1beta1\DeleteServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/DeleteService',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates an endpoint, and returns the new endpoint.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\CreateEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEndpoint(\Google\Cloud\ServiceDirectory\V1beta1\CreateEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/CreateEndpoint',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\Endpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all endpoints.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\ListEndpointsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListEndpoints(\Google\Cloud\ServiceDirectory\V1beta1\ListEndpointsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/ListEndpoints',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\ListEndpointsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets an endpoint.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\GetEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetEndpoint(\Google\Cloud\ServiceDirectory\V1beta1\GetEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/GetEndpoint',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\Endpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an endpoint.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\UpdateEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateEndpoint(\Google\Cloud\ServiceDirectory\V1beta1\UpdateEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/UpdateEndpoint',
        $argument,
        ['\Google\Cloud\ServiceDirectory\V1beta1\Endpoint', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an endpoint.
     * @param \Google\Cloud\ServiceDirectory\V1beta1\DeleteEndpointRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteEndpoint(\Google\Cloud\ServiceDirectory\V1beta1\DeleteEndpointRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/DeleteEndpoint',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the IAM Policy for a resource (namespace or service only).
     * @param \Google\Cloud\Iam\V1\GetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetIamPolicy(\Google\Cloud\Iam\V1\GetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/GetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Sets the IAM Policy for a resource (namespace or service only).
     * @param \Google\Cloud\Iam\V1\SetIamPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SetIamPolicy(\Google\Cloud\Iam\V1\SetIamPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/SetIamPolicy',
        $argument,
        ['\Google\Cloud\Iam\V1\Policy', 'decode'],
        $metadata, $options);
    }

    /**
     * Tests IAM permissions for a resource (namespace or service only).
     * @param \Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TestIamPermissions(\Google\Cloud\Iam\V1\TestIamPermissionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.servicedirectory.v1beta1.RegistrationService/TestIamPermissions',
        $argument,
        ['\Google\Cloud\Iam\V1\TestIamPermissionsResponse', 'decode'],
        $metadata, $options);
    }

}
