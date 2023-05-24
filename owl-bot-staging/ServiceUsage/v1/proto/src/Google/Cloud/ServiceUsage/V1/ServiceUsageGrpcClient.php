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
namespace Google\Cloud\ServiceUsage\V1;

/**
 * Enables services that service consumers want to use on Google Cloud Platform,
 * lists the available or enabled services, or disables services that service
 * consumers no longer use.
 *
 * See [Service Usage API](https://cloud.google.com/service-usage/docs/overview)
 */
class ServiceUsageGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Enable a service so that it can be used with a project.
     * @param \Google\Cloud\ServiceUsage\V1\EnableServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnableService(\Google\Cloud\ServiceUsage\V1\EnableServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.serviceusage.v1.ServiceUsage/EnableService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Disable a service so that it can no longer be used with a project.
     * This prevents unintended usage that may cause unexpected billing
     * charges or security leaks.
     *
     * It is not valid to call the disable method on a service that is not
     * currently enabled. Callers will receive a `FAILED_PRECONDITION` status if
     * the target service is not currently enabled.
     * @param \Google\Cloud\ServiceUsage\V1\DisableServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DisableService(\Google\Cloud\ServiceUsage\V1\DisableServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.serviceusage.v1.ServiceUsage/DisableService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the service configuration and enabled state for a given service.
     * @param \Google\Cloud\ServiceUsage\V1\GetServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetService(\Google\Cloud\ServiceUsage\V1\GetServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.serviceusage.v1.ServiceUsage/GetService',
        $argument,
        ['\Google\Cloud\ServiceUsage\V1\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * List all services available to the specified project, and the current
     * state of those services with respect to the project. The list includes
     * all public services, all services for which the calling user has the
     * `servicemanagement.services.bind` permission, and all services that have
     * already been enabled on the project. The list can be filtered to
     * only include services in a specific state, for example to only include
     * services enabled on the project.
     *
     * WARNING: If you need to query enabled services frequently or across
     * an organization, you should use
     * [Cloud Asset Inventory
     * API](https://cloud.google.com/asset-inventory/docs/apis), which provides
     * higher throughput and richer filtering capability.
     * @param \Google\Cloud\ServiceUsage\V1\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\ServiceUsage\V1\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.serviceusage.v1.ServiceUsage/ListServices',
        $argument,
        ['\Google\Cloud\ServiceUsage\V1\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Enable multiple services on a project. The operation is atomic: if enabling
     * any service fails, then the entire batch fails, and no state changes occur.
     * To enable a single service, use the `EnableService` method instead.
     * @param \Google\Cloud\ServiceUsage\V1\BatchEnableServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchEnableServices(\Google\Cloud\ServiceUsage\V1\BatchEnableServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.serviceusage.v1.ServiceUsage/BatchEnableServices',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the service configurations and enabled states for a given list of
     * services.
     * @param \Google\Cloud\ServiceUsage\V1\BatchGetServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchGetServices(\Google\Cloud\ServiceUsage\V1\BatchGetServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.serviceusage.v1.ServiceUsage/BatchGetServices',
        $argument,
        ['\Google\Cloud\ServiceUsage\V1\BatchGetServicesResponse', 'decode'],
        $metadata, $options);
    }

}
