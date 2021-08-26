<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2021 Google LLC.
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
namespace Google\Cloud\ServiceManagement\V1;

/**
 * [Google Service Management API](https://cloud.google.com/service-management/overview)
 */
class ServiceManagerGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists managed services.
     *
     * Returns all public services. For authenticated users, also returns all
     * services the calling user has "servicemanagement.services.get" permission
     * for.
     *
     * **BETA:** If the caller specifies the `consumer_id`, it returns only the
     * services enabled on the consumer. The `consumer_id` must have the format
     * of "project:{PROJECT-ID}".
     * @param \Google\Cloud\ServiceManagement\V1\ListServicesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServices(\Google\Cloud\ServiceManagement\V1\ListServicesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/ListServices',
        $argument,
        ['\Google\Cloud\ServiceManagement\V1\ListServicesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a managed service. Authentication is required unless the service is
     * public.
     * @param \Google\Cloud\ServiceManagement\V1\GetServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetService(\Google\Cloud\ServiceManagement\V1\GetServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/GetService',
        $argument,
        ['\Google\Cloud\ServiceManagement\V1\ManagedService', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new managed service.
     * Please note one producer project can own no more than 20 services.
     *
     * Operation<response: ManagedService>
     * @param \Google\Cloud\ServiceManagement\V1\CreateServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateService(\Google\Cloud\ServiceManagement\V1\CreateServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/CreateService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a managed service. This method will change the service to the
     * `Soft-Delete` state for 30 days. Within this period, service producers may
     * call [UndeleteService][google.api.servicemanagement.v1.ServiceManager.UndeleteService] to restore the service.
     * After 30 days, the service will be permanently deleted.
     *
     * Operation<response: google.protobuf.Empty>
     * @param \Google\Cloud\ServiceManagement\V1\DeleteServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteService(\Google\Cloud\ServiceManagement\V1\DeleteServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/DeleteService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Revives a previously deleted managed service. The method restores the
     * service using the configuration at the time the service was deleted.
     * The target service must exist and must have been deleted within the
     * last 30 days.
     *
     * Operation<response: UndeleteServiceResponse>
     * @param \Google\Cloud\ServiceManagement\V1\UndeleteServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UndeleteService(\Google\Cloud\ServiceManagement\V1\UndeleteServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/UndeleteService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the history of the service configuration for a managed service,
     * from the newest to the oldest.
     * @param \Google\Cloud\ServiceManagement\V1\ListServiceConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServiceConfigs(\Google\Cloud\ServiceManagement\V1\ListServiceConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/ListServiceConfigs',
        $argument,
        ['\Google\Cloud\ServiceManagement\V1\ListServiceConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a service configuration (version) for a managed service.
     * @param \Google\Cloud\ServiceManagement\V1\GetServiceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetServiceConfig(\Google\Cloud\ServiceManagement\V1\GetServiceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/GetServiceConfig',
        $argument,
        ['\Google\Api\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new service configuration (version) for a managed service.
     * This method only stores the service configuration. To roll out the service
     * configuration to backend systems please call
     * [CreateServiceRollout][google.api.servicemanagement.v1.ServiceManager.CreateServiceRollout].
     *
     * Only the 100 most recent service configurations and ones referenced by
     * existing rollouts are kept for each service. The rest will be deleted
     * eventually.
     * @param \Google\Cloud\ServiceManagement\V1\CreateServiceConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateServiceConfig(\Google\Cloud\ServiceManagement\V1\CreateServiceConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/CreateServiceConfig',
        $argument,
        ['\Google\Api\Service', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new service configuration (version) for a managed service based
     * on
     * user-supplied configuration source files (for example: OpenAPI
     * Specification). This method stores the source configurations as well as the
     * generated service configuration. To rollout the service configuration to
     * other services,
     * please call [CreateServiceRollout][google.api.servicemanagement.v1.ServiceManager.CreateServiceRollout].
     *
     * Only the 100 most recent configuration sources and ones referenced by
     * existing service configurtions are kept for each service. The rest will be
     * deleted eventually.
     *
     * Operation<response: SubmitConfigSourceResponse>
     * @param \Google\Cloud\ServiceManagement\V1\SubmitConfigSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function SubmitConfigSource(\Google\Cloud\ServiceManagement\V1\SubmitConfigSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/SubmitConfigSource',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists the history of the service configuration rollouts for a managed
     * service, from the newest to the oldest.
     * @param \Google\Cloud\ServiceManagement\V1\ListServiceRolloutsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServiceRollouts(\Google\Cloud\ServiceManagement\V1\ListServiceRolloutsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/ListServiceRollouts',
        $argument,
        ['\Google\Cloud\ServiceManagement\V1\ListServiceRolloutsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a service configuration [rollout][google.api.servicemanagement.v1.Rollout].
     * @param \Google\Cloud\ServiceManagement\V1\GetServiceRolloutRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetServiceRollout(\Google\Cloud\ServiceManagement\V1\GetServiceRolloutRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/GetServiceRollout',
        $argument,
        ['\Google\Cloud\ServiceManagement\V1\Rollout', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new service configuration rollout. Based on rollout, the
     * Google Service Management will roll out the service configurations to
     * different backend services. For example, the logging configuration will be
     * pushed to Google Cloud Logging.
     *
     * Please note that any previous pending and running Rollouts and associated
     * Operations will be automatically cancelled so that the latest Rollout will
     * not be blocked by previous Rollouts.
     *
     * Only the 100 most recent (in any state) and the last 10 successful (if not
     * already part of the set of 100 most recent) rollouts are kept for each
     * service. The rest will be deleted eventually.
     *
     * Operation<response: Rollout>
     * @param \Google\Cloud\ServiceManagement\V1\CreateServiceRolloutRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateServiceRollout(\Google\Cloud\ServiceManagement\V1\CreateServiceRolloutRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/CreateServiceRollout',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates and returns a report (errors, warnings and changes from
     * existing configurations) associated with
     * GenerateConfigReportRequest.new_value
     *
     * If GenerateConfigReportRequest.old_value is specified,
     * GenerateConfigReportRequest will contain a single ChangeReport based on the
     * comparison between GenerateConfigReportRequest.new_value and
     * GenerateConfigReportRequest.old_value.
     * If GenerateConfigReportRequest.old_value is not specified, this method
     * will compare GenerateConfigReportRequest.new_value with the last pushed
     * service configuration.
     * @param \Google\Cloud\ServiceManagement\V1\GenerateConfigReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateConfigReport(\Google\Cloud\ServiceManagement\V1\GenerateConfigReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/GenerateConfigReport',
        $argument,
        ['\Google\Cloud\ServiceManagement\V1\GenerateConfigReportResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Enables a [service][google.api.servicemanagement.v1.ManagedService] for a project, so it can be used
     * for the project. See
     * [Cloud Auth Guide](https://cloud.google.com/docs/authentication) for
     * more information.
     *
     * Operation<response: EnableServiceResponse>
     * @param \Google\Cloud\ServiceManagement\V1\EnableServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function EnableService(\Google\Cloud\ServiceManagement\V1\EnableServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/EnableService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Disables a [service][google.api.servicemanagement.v1.ManagedService] for a project, so it can no longer be
     * be used for the project. It prevents accidental usage that may cause
     * unexpected billing charges or security leaks.
     *
     * Operation<response: DisableServiceResponse>
     * @param \Google\Cloud\ServiceManagement\V1\DisableServiceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DisableService(\Google\Cloud\ServiceManagement\V1\DisableServiceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.api.servicemanagement.v1.ServiceManager/DisableService',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
