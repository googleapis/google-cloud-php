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
namespace Google\Cloud\Monitoring\V3;

/**
 * The Cloud Monitoring Service-Oriented Monitoring API has endpoints for
 * managing and querying aspects of a workspace's services. These include the
 * `Service`'s monitored resources, its Service-Level Objectives, and a taxonomy
 * of categorized Health Metrics.
 */
class ServiceMonitoringServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create a `Service`.
     * @param \Google\Cloud\Monitoring\V3\CreateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateService(\Google\Cloud\Monitoring\V3\CreateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/CreateService',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the named `Service`.
     * @param \Google\Cloud\Monitoring\V3\GetServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetService(\Google\Cloud\Monitoring\V3\GetServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/GetService',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * List `Service`s for this workspace.
     * @param \Google\Cloud\Monitoring\V3\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\Monitoring\V3\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/ListServices',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update this `Service`.
     * @param \Google\Cloud\Monitoring\V3\UpdateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateService(\Google\Cloud\Monitoring\V3\UpdateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/UpdateService',
        $argument,
        ['\Google\Cloud\Monitoring\V3\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Soft delete this `Service`.
     * @param \Google\Cloud\Monitoring\V3\DeleteServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteService(\Google\Cloud\Monitoring\V3\DeleteServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/DeleteService',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Create a `ServiceLevelObjective` for the given `Service`.
     * @param \Google\Cloud\Monitoring\V3\CreateServiceLevelObjectiveRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateServiceLevelObjective(\Google\Cloud\Monitoring\V3\CreateServiceLevelObjectiveRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/CreateServiceLevelObjective',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ServiceLevelObjective', 'decode'],
        $metadata, $options);
    }

    /**
     * Get a `ServiceLevelObjective` by name.
     * @param \Google\Cloud\Monitoring\V3\GetServiceLevelObjectiveRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetServiceLevelObjective(\Google\Cloud\Monitoring\V3\GetServiceLevelObjectiveRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/GetServiceLevelObjective',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ServiceLevelObjective', 'decode'],
        $metadata, $options);
    }

    /**
     * List the `ServiceLevelObjective`s for the given `Service`.
     * @param \Google\Cloud\Monitoring\V3\ListServiceLevelObjectivesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServiceLevelObjectives(\Google\Cloud\Monitoring\V3\ListServiceLevelObjectivesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/ListServiceLevelObjectives',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListServiceLevelObjectivesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Update the given `ServiceLevelObjective`.
     * @param \Google\Cloud\Monitoring\V3\UpdateServiceLevelObjectiveRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateServiceLevelObjective(\Google\Cloud\Monitoring\V3\UpdateServiceLevelObjectiveRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/UpdateServiceLevelObjective',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ServiceLevelObjective', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete the given `ServiceLevelObjective`.
     * @param \Google\Cloud\Monitoring\V3\DeleteServiceLevelObjectiveRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteServiceLevelObjective(\Google\Cloud\Monitoring\V3\DeleteServiceLevelObjectiveRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.ServiceMonitoringService/DeleteServiceLevelObjective',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

}
