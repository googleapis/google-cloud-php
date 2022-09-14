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
 * The AlertPolicyService API is used to manage (list, create, delete,
 * edit) alert policies in Cloud Monitoring. An alerting policy is
 * a description of the conditions under which some aspect of your
 * system is considered to be "unhealthy" and the ways to notify
 * people or services about this state. In addition to using this API, alert
 * policies can also be managed through
 * [Cloud Monitoring](https://cloud.google.com/monitoring/docs/),
 * which can be reached by clicking the "Monitoring" tab in
 * [Cloud console](https://console.cloud.google.com/).
 */
class AlertPolicyServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists the existing alerting policies for the workspace.
     * @param \Google\Cloud\Monitoring\V3\ListAlertPoliciesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListAlertPolicies(\Google\Cloud\Monitoring\V3\ListAlertPoliciesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.AlertPolicyService/ListAlertPolicies',
        $argument,
        ['\Google\Cloud\Monitoring\V3\ListAlertPoliciesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single alerting policy.
     * @param \Google\Cloud\Monitoring\V3\GetAlertPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetAlertPolicy(\Google\Cloud\Monitoring\V3\GetAlertPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.AlertPolicyService/GetAlertPolicy',
        $argument,
        ['\Google\Cloud\Monitoring\V3\AlertPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new alerting policy.
     * @param \Google\Cloud\Monitoring\V3\CreateAlertPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateAlertPolicy(\Google\Cloud\Monitoring\V3\CreateAlertPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.AlertPolicyService/CreateAlertPolicy',
        $argument,
        ['\Google\Cloud\Monitoring\V3\AlertPolicy', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes an alerting policy.
     * @param \Google\Cloud\Monitoring\V3\DeleteAlertPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteAlertPolicy(\Google\Cloud\Monitoring\V3\DeleteAlertPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.AlertPolicyService/DeleteAlertPolicy',
        $argument,
        ['\Google\Protobuf\GPBEmpty', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates an alerting policy. You can either replace the entire policy with
     * a new one or replace only certain fields in the current alerting policy by
     * specifying the fields to be updated via `updateMask`. Returns the
     * updated alerting policy.
     * @param \Google\Cloud\Monitoring\V3\UpdateAlertPolicyRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateAlertPolicy(\Google\Cloud\Monitoring\V3\UpdateAlertPolicyRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.monitoring.v3.AlertPolicyService/UpdateAlertPolicy',
        $argument,
        ['\Google\Cloud\Monitoring\V3\AlertPolicy', 'decode'],
        $metadata, $options);
    }

}
