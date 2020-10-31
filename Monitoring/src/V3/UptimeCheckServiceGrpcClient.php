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
 * The UptimeCheckService API is used to manage (list, create, delete, edit)
 * Uptime check configurations in the Stackdriver Monitoring product. An Uptime
 * check is a piece of configuration that determines which resources and
 * services to monitor for availability. These configurations can also be
 * configured interactively by navigating to the [Cloud Console]
 * (http://console.cloud.google.com), selecting the appropriate project,
 * clicking on "Monitoring" on the left-hand side to navigate to Stackdriver,
 * and then clicking on "Uptime".
 */
class UptimeCheckServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the existing valid Uptime check configurations for the project
     * (leaving out any invalid configurations).
     * @param \Google\Cloud\Monitoring\V3\ListUptimeCheckConfigsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListUptimeCheckConfigs(\Google\Cloud\Monitoring\V3\ListUptimeCheckConfigsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.UptimeCheckService/ListUptimeCheckConfigs',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListUptimeCheckConfigsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single Uptime check configuration.
     * @param \Google\Cloud\Monitoring\V3\GetUptimeCheckConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetUptimeCheckConfig(\Google\Cloud\Monitoring\V3\GetUptimeCheckConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.UptimeCheckService/GetUptimeCheckConfig',
        $argument,
        ['\Google\Cloud\Monitoring\V3\UptimeCheckConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Uptime check configuration.
     * @param \Google\Cloud\Monitoring\V3\CreateUptimeCheckConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateUptimeCheckConfig(\Google\Cloud\Monitoring\V3\CreateUptimeCheckConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.UptimeCheckService/CreateUptimeCheckConfig',
        $argument,
        ['\Google\Cloud\Monitoring\V3\UptimeCheckConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an Uptime check configuration. You can either replace the entire
     * configuration with a new one or replace only certain fields in the current
     * configuration by specifying the fields to be updated via `updateMask`.
     * Returns the updated configuration.
     * @param \Google\Cloud\Monitoring\V3\UpdateUptimeCheckConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateUptimeCheckConfig(\Google\Cloud\Monitoring\V3\UpdateUptimeCheckConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.UptimeCheckService/UpdateUptimeCheckConfig',
        $argument,
        ['\Google\Cloud\Monitoring\V3\UptimeCheckConfig', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an Uptime check configuration. Note that this method will fail
     * if the Uptime check configuration is referenced by an alert policy or
     * other dependent configs that would be rendered invalid by the deletion.
     * @param \Google\Cloud\Monitoring\V3\DeleteUptimeCheckConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteUptimeCheckConfig(\Google\Cloud\Monitoring\V3\DeleteUptimeCheckConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.UptimeCheckService/DeleteUptimeCheckConfig',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Returns the list of IP addresses that checkers run from
     * @param \Google\Cloud\Monitoring\V3\ListUptimeCheckIpsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListUptimeCheckIps(\Google\Cloud\Monitoring\V3\ListUptimeCheckIpsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.UptimeCheckService/ListUptimeCheckIps',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListUptimeCheckIpsResponse', 'decode'],
        $metadata, $options);
    }

}
