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
namespace Google\Cloud\OsConfig\V1;

/**
 * Zonal OS Config API
 *
 * The OS Config service is the server-side component that allows users to
 * manage package installations and patch jobs for Compute Engine VM instances.
 */
class OsConfigZonalServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Create an OS policy assignment.
     *
     * This method also creates the first revision of the OS policy assignment.
     *
     * This method returns a long running operation (LRO) that contains the
     * rollout details. The rollout can be cancelled by cancelling the LRO.
     *
     * For more information, see [Method:
     * projects.locations.osPolicyAssignments.operations.cancel](https://cloud.google.com/compute/docs/osconfig/rest/v1/projects.locations.osPolicyAssignments.operations/cancel).
     * @param \Google\Cloud\OsConfig\V1\CreateOSPolicyAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateOSPolicyAssignment(\Google\Cloud\OsConfig\V1\CreateOSPolicyAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/CreateOSPolicyAssignment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Update an existing OS policy assignment.
     *
     * This method creates a new revision of the OS policy assignment.
     *
     * This method returns a long running operation (LRO) that contains the
     * rollout details. The rollout can be cancelled by cancelling the LRO.
     *
     * For more information, see [Method:
     * projects.locations.osPolicyAssignments.operations.cancel](https://cloud.google.com/compute/docs/osconfig/rest/v1/projects.locations.osPolicyAssignments.operations/cancel).
     * @param \Google\Cloud\OsConfig\V1\UpdateOSPolicyAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateOSPolicyAssignment(\Google\Cloud\OsConfig\V1\UpdateOSPolicyAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/UpdateOSPolicyAssignment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieve an existing OS policy assignment.
     *
     * This method always returns the latest revision. In order to retrieve a
     * previous revision of the assignment, also provide the revision ID in the
     * `name` parameter.
     * @param \Google\Cloud\OsConfig\V1\GetOSPolicyAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOSPolicyAssignment(\Google\Cloud\OsConfig\V1\GetOSPolicyAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/GetOSPolicyAssignment',
        $argument,
        ['\Google\Cloud\OsConfig\V1\OSPolicyAssignment', 'decode'],
        $metadata, $options);
    }

    /**
     * List the OS policy assignments under the parent resource.
     *
     * For each OS policy assignment, the latest revision is returned.
     * @param \Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListOSPolicyAssignments(\Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/ListOSPolicyAssignments',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * List the OS policy assignment revisions for a given OS policy assignment.
     * @param \Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentRevisionsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListOSPolicyAssignmentRevisions(\Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentRevisionsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/ListOSPolicyAssignmentRevisions',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentRevisionsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Delete the OS policy assignment.
     *
     * This method creates a new revision of the OS policy assignment.
     *
     * This method returns a long running operation (LRO) that contains the
     * rollout details. The rollout can be cancelled by cancelling the LRO.
     *
     * If the LRO completes and is not cancelled, all revisions associated with
     * the OS policy assignment are deleted.
     *
     * For more information, see [Method:
     * projects.locations.osPolicyAssignments.operations.cancel](https://cloud.google.com/compute/docs/osconfig/rest/v1/projects.locations.osPolicyAssignments.operations/cancel).
     * @param \Google\Cloud\OsConfig\V1\DeleteOSPolicyAssignmentRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteOSPolicyAssignment(\Google\Cloud\OsConfig\V1\DeleteOSPolicyAssignmentRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/DeleteOSPolicyAssignment',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Get the OS policy asssignment report for the specified Compute Engine VM
     * instance.
     * @param \Google\Cloud\OsConfig\V1\GetOSPolicyAssignmentReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetOSPolicyAssignmentReport(\Google\Cloud\OsConfig\V1\GetOSPolicyAssignmentReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/GetOSPolicyAssignmentReport',
        $argument,
        ['\Google\Cloud\OsConfig\V1\OSPolicyAssignmentReport', 'decode'],
        $metadata, $options);
    }

    /**
     * List OS policy asssignment reports for all Compute Engine VM instances in
     * the specified zone.
     * @param \Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentReportsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListOSPolicyAssignmentReports(\Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentReportsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/ListOSPolicyAssignmentReports',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListOSPolicyAssignmentReportsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get inventory data for the specified VM instance. If the VM has no
     * associated inventory, the message `NOT_FOUND` is returned.
     * @param \Google\Cloud\OsConfig\V1\GetInventoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInventory(\Google\Cloud\OsConfig\V1\GetInventoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/GetInventory',
        $argument,
        ['\Google\Cloud\OsConfig\V1\Inventory', 'decode'],
        $metadata, $options);
    }

    /**
     * List inventory data for all VM instances in the specified zone.
     * @param \Google\Cloud\OsConfig\V1\ListInventoriesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInventories(\Google\Cloud\OsConfig\V1\ListInventoriesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/ListInventories',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListInventoriesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets the vulnerability report for the specified VM instance. Only VMs with
     * inventory data have vulnerability reports associated with them.
     * @param \Google\Cloud\OsConfig\V1\GetVulnerabilityReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetVulnerabilityReport(\Google\Cloud\OsConfig\V1\GetVulnerabilityReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/GetVulnerabilityReport',
        $argument,
        ['\Google\Cloud\OsConfig\V1\VulnerabilityReport', 'decode'],
        $metadata, $options);
    }

    /**
     * List vulnerability reports for all VM instances in the specified zone.
     * @param \Google\Cloud\OsConfig\V1\ListVulnerabilityReportsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListVulnerabilityReports(\Google\Cloud\OsConfig\V1\ListVulnerabilityReportsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.osconfig.v1.OsConfigZonalService/ListVulnerabilityReports',
        $argument,
        ['\Google\Cloud\OsConfig\V1\ListVulnerabilityReportsResponse', 'decode'],
        $metadata, $options);
    }

}
