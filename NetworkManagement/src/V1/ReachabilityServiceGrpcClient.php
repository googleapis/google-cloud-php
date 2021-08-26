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
namespace Google\Cloud\NetworkManagement\V1;

/**
 * The Reachability service in Google Cloud Network Management API
 *
 * The Reachability service in the Google Cloud Network Management API provides
 * services that analyze the reachability within a single Google Virtual Private
 * Cloud (VPC) network, between peered VPC networks, between VPC and on-premises
 * networks, or between VPC networks and internet hosts. A reachability analysis
 * is based on Google Cloud network configurations.
 *
 * You can use the analysis results to verify these configurations and
 * to troubleshoot connectivity issues.
 */
class ReachabilityServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists all Connectivity Tests owned by a project.
     * @param \Google\Cloud\NetworkManagement\V1\ListConnectivityTestsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListConnectivityTests(\Google\Cloud\NetworkManagement\V1\ListConnectivityTestsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkmanagement.v1.ReachabilityService/ListConnectivityTests',
        $argument,
        ['\Google\Cloud\NetworkManagement\V1\ListConnectivityTestsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the details of a specific Connectivity Test.
     * @param \Google\Cloud\NetworkManagement\V1\GetConnectivityTestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnectivityTest(\Google\Cloud\NetworkManagement\V1\GetConnectivityTestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkmanagement.v1.ReachabilityService/GetConnectivityTest',
        $argument,
        ['\Google\Cloud\NetworkManagement\V1\ConnectivityTest', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Connectivity Test.
     * After you create a test, the reachability analysis is performed as part
     * of the long running operation, which completes when the analysis completes.
     *
     * If the endpoint specifications in `ConnectivityTest` are invalid
     * (for example, containing non-existent resources in the network, or you
     * don't have read permissions to the network configurations of listed
     * projects), then the reachability result returns a value of `UNKNOWN`.
     *
     * If the endpoint specifications in `ConnectivityTest` are
     * incomplete, the reachability result returns a value of
     * <code>AMBIGUOUS</code>. For more information,
     * see the Connectivity Test documentation.
     * @param \Google\Cloud\NetworkManagement\V1\CreateConnectivityTestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateConnectivityTest(\Google\Cloud\NetworkManagement\V1\CreateConnectivityTestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkmanagement.v1.ReachabilityService/CreateConnectivityTest',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the configuration of an existing `ConnectivityTest`.
     * After you update a test, the reachability analysis is performed as part
     * of the long running operation, which completes when the analysis completes.
     * The Reachability state in the test resource is updated with the new result.
     *
     * If the endpoint specifications in `ConnectivityTest` are invalid
     * (for example, they contain non-existent resources in the network, or the
     * user does not have read permissions to the network configurations of
     * listed projects), then the reachability result returns a value of
     * <code>UNKNOWN</code>.
     *
     * If the endpoint specifications in `ConnectivityTest` are incomplete, the
     * reachability result returns a value of `AMBIGUOUS`. See the documentation
     * in `ConnectivityTest` for for more details.
     * @param \Google\Cloud\NetworkManagement\V1\UpdateConnectivityTestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateConnectivityTest(\Google\Cloud\NetworkManagement\V1\UpdateConnectivityTestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkmanagement.v1.ReachabilityService/UpdateConnectivityTest',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Rerun an existing `ConnectivityTest`.
     * After the user triggers the rerun, the reachability analysis is performed
     * as part of the long running operation, which completes when the analysis
     * completes.
     *
     * Even though the test configuration remains the same, the reachability
     * result may change due to underlying network configuration changes.
     *
     * If the endpoint specifications in `ConnectivityTest` become invalid (for
     * example, specified resources are deleted in the network, or you lost
     * read permissions to the network configurations of listed projects), then
     * the reachability result returns a value of `UNKNOWN`.
     * @param \Google\Cloud\NetworkManagement\V1\RerunConnectivityTestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RerunConnectivityTest(\Google\Cloud\NetworkManagement\V1\RerunConnectivityTestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkmanagement.v1.ReachabilityService/RerunConnectivityTest',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a specific `ConnectivityTest`.
     * @param \Google\Cloud\NetworkManagement\V1\DeleteConnectivityTestRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteConnectivityTest(\Google\Cloud\NetworkManagement\V1\DeleteConnectivityTestRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.networkmanagement.v1.ReachabilityService/DeleteConnectivityTest',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
