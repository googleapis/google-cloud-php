<?php
// GENERATED CODE -- DO NOT EDIT!

// Original file comments:
// Copyright 2022 Google LLC
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
namespace Google\Cloud\VMMigration\V1;

/**
 * VM Migration Service
 */
class VmMigrationGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Sources in a given project and location.
     * @param \Google\Cloud\VMMigration\V1\ListSourcesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSources(\Google\Cloud\VMMigration\V1\ListSourcesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListSources',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListSourcesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Source.
     * @param \Google\Cloud\VMMigration\V1\GetSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetSource(\Google\Cloud\VMMigration\V1\GetSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetSource',
        $argument,
        ['\Google\Cloud\VMMigration\V1\Source', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Source in a given project and location.
     * @param \Google\Cloud\VMMigration\V1\CreateSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSource(\Google\Cloud\VMMigration\V1\CreateSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateSource',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Source.
     * @param \Google\Cloud\VMMigration\V1\UpdateSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateSource(\Google\Cloud\VMMigration\V1\UpdateSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/UpdateSource',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Source.
     * @param \Google\Cloud\VMMigration\V1\DeleteSourceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteSource(\Google\Cloud\VMMigration\V1\DeleteSourceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/DeleteSource',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * List remote source's inventory of VMs.
     * The remote source is the onprem vCenter (remote in the sense it's not in
     * Compute Engine). The inventory describes the list of existing VMs in that
     * source. Note that this operation lists the VMs on the remote source, as
     * opposed to listing the MigratingVms resources in the vmmigration service.
     * @param \Google\Cloud\VMMigration\V1\FetchInventoryRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FetchInventory(\Google\Cloud\VMMigration\V1\FetchInventoryRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/FetchInventory',
        $argument,
        ['\Google\Cloud\VMMigration\V1\FetchInventoryResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Utilization Reports of the given Source.
     * @param \Google\Cloud\VMMigration\V1\ListUtilizationReportsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListUtilizationReports(\Google\Cloud\VMMigration\V1\ListUtilizationReportsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListUtilizationReports',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListUtilizationReportsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets a single Utilization Report.
     * @param \Google\Cloud\VMMigration\V1\GetUtilizationReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetUtilizationReport(\Google\Cloud\VMMigration\V1\GetUtilizationReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetUtilizationReport',
        $argument,
        ['\Google\Cloud\VMMigration\V1\UtilizationReport', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new UtilizationReport.
     * @param \Google\Cloud\VMMigration\V1\CreateUtilizationReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateUtilizationReport(\Google\Cloud\VMMigration\V1\CreateUtilizationReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateUtilizationReport',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Utilization Report.
     * @param \Google\Cloud\VMMigration\V1\DeleteUtilizationReportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteUtilizationReport(\Google\Cloud\VMMigration\V1\DeleteUtilizationReportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/DeleteUtilizationReport',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists DatacenterConnectors in a given Source.
     * @param \Google\Cloud\VMMigration\V1\ListDatacenterConnectorsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListDatacenterConnectors(\Google\Cloud\VMMigration\V1\ListDatacenterConnectorsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListDatacenterConnectors',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListDatacenterConnectorsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single DatacenterConnector.
     * @param \Google\Cloud\VMMigration\V1\GetDatacenterConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetDatacenterConnector(\Google\Cloud\VMMigration\V1\GetDatacenterConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetDatacenterConnector',
        $argument,
        ['\Google\Cloud\VMMigration\V1\DatacenterConnector', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new DatacenterConnector in a given Source.
     * @param \Google\Cloud\VMMigration\V1\CreateDatacenterConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateDatacenterConnector(\Google\Cloud\VMMigration\V1\CreateDatacenterConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateDatacenterConnector',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single DatacenterConnector.
     * @param \Google\Cloud\VMMigration\V1\DeleteDatacenterConnectorRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteDatacenterConnector(\Google\Cloud\VMMigration\V1\DeleteDatacenterConnectorRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/DeleteDatacenterConnector',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Upgrades the appliance relate to this DatacenterConnector to the in-place
     * updateable version.
     * @param \Google\Cloud\VMMigration\V1\UpgradeApplianceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpgradeAppliance(\Google\Cloud\VMMigration\V1\UpgradeApplianceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/UpgradeAppliance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new MigratingVm in a given Source.
     * @param \Google\Cloud\VMMigration\V1\CreateMigratingVmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateMigratingVm(\Google\Cloud\VMMigration\V1\CreateMigratingVmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateMigratingVm',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists MigratingVms in a given Source.
     * @param \Google\Cloud\VMMigration\V1\ListMigratingVmsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListMigratingVms(\Google\Cloud\VMMigration\V1\ListMigratingVmsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListMigratingVms',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListMigratingVmsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single MigratingVm.
     * @param \Google\Cloud\VMMigration\V1\GetMigratingVmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetMigratingVm(\Google\Cloud\VMMigration\V1\GetMigratingVmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetMigratingVm',
        $argument,
        ['\Google\Cloud\VMMigration\V1\MigratingVm', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single MigratingVm.
     * @param \Google\Cloud\VMMigration\V1\UpdateMigratingVmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateMigratingVm(\Google\Cloud\VMMigration\V1\UpdateMigratingVmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/UpdateMigratingVm',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single MigratingVm.
     * @param \Google\Cloud\VMMigration\V1\DeleteMigratingVmRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteMigratingVm(\Google\Cloud\VMMigration\V1\DeleteMigratingVmRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/DeleteMigratingVm',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts migration for a VM. Starts the process of uploading
     * data and creating snapshots, in replication cycles scheduled by the policy.
     * @param \Google\Cloud\VMMigration\V1\StartMigrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartMigration(\Google\Cloud\VMMigration\V1\StartMigrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/StartMigration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Resumes a migration for a VM. When called on a paused migration, will start
     * the process of uploading data and creating snapshots; when called on a
     * completed cut-over migration, will update the migration to active state and
     * start the process of uploading data and creating snapshots.
     * @param \Google\Cloud\VMMigration\V1\ResumeMigrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResumeMigration(\Google\Cloud\VMMigration\V1\ResumeMigrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ResumeMigration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Pauses a migration for a VM. If cycle tasks are running they will be
     * cancelled, preserving source task data. Further replication cycles will not
     * be triggered while the VM is paused.
     * @param \Google\Cloud\VMMigration\V1\PauseMigrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PauseMigration(\Google\Cloud\VMMigration\V1\PauseMigrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/PauseMigration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Marks a migration as completed, deleting migration resources that are no
     * longer being used. Only applicable after cutover is done.
     * @param \Google\Cloud\VMMigration\V1\FinalizeMigrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FinalizeMigration(\Google\Cloud\VMMigration\V1\FinalizeMigrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/FinalizeMigration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Initiates a Clone of a specific migrating VM.
     * @param \Google\Cloud\VMMigration\V1\CreateCloneJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCloneJob(\Google\Cloud\VMMigration\V1\CreateCloneJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateCloneJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Initiates the cancellation of a running clone job.
     * @param \Google\Cloud\VMMigration\V1\CancelCloneJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelCloneJob(\Google\Cloud\VMMigration\V1\CancelCloneJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CancelCloneJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CloneJobs of a given migrating VM.
     * @param \Google\Cloud\VMMigration\V1\ListCloneJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCloneJobs(\Google\Cloud\VMMigration\V1\ListCloneJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListCloneJobs',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListCloneJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single CloneJob.
     * @param \Google\Cloud\VMMigration\V1\GetCloneJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCloneJob(\Google\Cloud\VMMigration\V1\GetCloneJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetCloneJob',
        $argument,
        ['\Google\Cloud\VMMigration\V1\CloneJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Initiates a Cutover of a specific migrating VM.
     * The returned LRO is completed when the cutover job resource is created
     * and the job is initiated.
     * @param \Google\Cloud\VMMigration\V1\CreateCutoverJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCutoverJob(\Google\Cloud\VMMigration\V1\CreateCutoverJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateCutoverJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Initiates the cancellation of a running cutover job.
     * @param \Google\Cloud\VMMigration\V1\CancelCutoverJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CancelCutoverJob(\Google\Cloud\VMMigration\V1\CancelCutoverJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CancelCutoverJob',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists CutoverJobs of a given migrating VM.
     * @param \Google\Cloud\VMMigration\V1\ListCutoverJobsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListCutoverJobs(\Google\Cloud\VMMigration\V1\ListCutoverJobsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListCutoverJobs',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListCutoverJobsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single CutoverJob.
     * @param \Google\Cloud\VMMigration\V1\GetCutoverJobRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCutoverJob(\Google\Cloud\VMMigration\V1\GetCutoverJobRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetCutoverJob',
        $argument,
        ['\Google\Cloud\VMMigration\V1\CutoverJob', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Groups in a given project and location.
     * @param \Google\Cloud\VMMigration\V1\ListGroupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListGroups(\Google\Cloud\VMMigration\V1\ListGroupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListGroups',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListGroupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Group.
     * @param \Google\Cloud\VMMigration\V1\GetGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetGroup(\Google\Cloud\VMMigration\V1\GetGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetGroup',
        $argument,
        ['\Google\Cloud\VMMigration\V1\Group', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Group in a given project and location.
     * @param \Google\Cloud\VMMigration\V1\CreateGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateGroup(\Google\Cloud\VMMigration\V1\CreateGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateGroup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Group.
     * @param \Google\Cloud\VMMigration\V1\UpdateGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateGroup(\Google\Cloud\VMMigration\V1\UpdateGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/UpdateGroup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Group.
     * @param \Google\Cloud\VMMigration\V1\DeleteGroupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteGroup(\Google\Cloud\VMMigration\V1\DeleteGroupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/DeleteGroup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Adds a MigratingVm to a Group.
     * @param \Google\Cloud\VMMigration\V1\AddGroupMigrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddGroupMigration(\Google\Cloud\VMMigration\V1\AddGroupMigrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/AddGroupMigration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Removes a MigratingVm from a Group.
     * @param \Google\Cloud\VMMigration\V1\RemoveGroupMigrationRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RemoveGroupMigration(\Google\Cloud\VMMigration\V1\RemoveGroupMigrationRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/RemoveGroupMigration',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists TargetProjects in a given project.
     *
     * NOTE: TargetProject is a global resource; hence the only supported value
     * for location is `global`.
     * @param \Google\Cloud\VMMigration\V1\ListTargetProjectsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListTargetProjects(\Google\Cloud\VMMigration\V1\ListTargetProjectsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/ListTargetProjects',
        $argument,
        ['\Google\Cloud\VMMigration\V1\ListTargetProjectsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single TargetProject.
     *
     * NOTE: TargetProject is a global resource; hence the only supported value
     * for location is `global`.
     * @param \Google\Cloud\VMMigration\V1\GetTargetProjectRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetTargetProject(\Google\Cloud\VMMigration\V1\GetTargetProjectRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/GetTargetProject',
        $argument,
        ['\Google\Cloud\VMMigration\V1\TargetProject', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new TargetProject in a given project.
     *
     * NOTE: TargetProject is a global resource; hence the only supported value
     * for location is `global`.
     * @param \Google\Cloud\VMMigration\V1\CreateTargetProjectRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateTargetProject(\Google\Cloud\VMMigration\V1\CreateTargetProjectRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/CreateTargetProject',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single TargetProject.
     *
     * NOTE: TargetProject is a global resource; hence the only supported value
     * for location is `global`.
     * @param \Google\Cloud\VMMigration\V1\UpdateTargetProjectRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateTargetProject(\Google\Cloud\VMMigration\V1\UpdateTargetProjectRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/UpdateTargetProject',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single TargetProject.
     *
     * NOTE: TargetProject is a global resource; hence the only supported value
     * for location is `global`.
     * @param \Google\Cloud\VMMigration\V1\DeleteTargetProjectRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteTargetProject(\Google\Cloud\VMMigration\V1\DeleteTargetProjectRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.vmmigration.v1.VmMigration/DeleteTargetProject',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

}
