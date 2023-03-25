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
namespace Google\Cloud\AlloyDb\V1beta;

/**
 * Service describing handlers for resources
 */
class AlloyDBAdminGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Lists Clusters in a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\ListClustersRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListClusters(\Google\Cloud\AlloyDb\V1beta\ListClustersRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/ListClusters',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\ListClustersResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Cluster.
     * @param \Google\Cloud\AlloyDb\V1beta\GetClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetCluster(\Google\Cloud\AlloyDb\V1beta\GetClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/GetCluster',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\Cluster', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Cluster in a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\CreateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateCluster(\Google\Cloud\AlloyDb\V1beta\CreateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/CreateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Cluster.
     * @param \Google\Cloud\AlloyDb\V1beta\UpdateClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateCluster(\Google\Cloud\AlloyDb\V1beta\UpdateClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/UpdateCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Cluster.
     * @param \Google\Cloud\AlloyDb\V1beta\DeleteClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteCluster(\Google\Cloud\AlloyDb\V1beta\DeleteClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/DeleteCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Promotes a SECONDARY cluster. This turns down replication
     * from the PRIMARY cluster and promotes a secondary cluster
     * into its own standalone cluster.
     * Imperative only.
     * @param \Google\Cloud\AlloyDb\V1beta\PromoteClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PromoteCluster(\Google\Cloud\AlloyDb\V1beta\PromoteClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/PromoteCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Cluster in a given project and location, with a volume
     * restored from the provided source, either a backup ID or a point-in-time
     * and a source cluster.
     * @param \Google\Cloud\AlloyDb\V1beta\RestoreClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreCluster(\Google\Cloud\AlloyDb\V1beta\RestoreClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/RestoreCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a cluster of type SECONDARY in the given location using
     * the primary cluster as the source.
     * @param \Google\Cloud\AlloyDb\V1beta\CreateSecondaryClusterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSecondaryCluster(\Google\Cloud\AlloyDb\V1beta\CreateSecondaryClusterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/CreateSecondaryCluster',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Instances in a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\ListInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListInstances(\Google\Cloud\AlloyDb\V1beta\ListInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/ListInstances',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\ListInstancesResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Instance.
     * @param \Google\Cloud\AlloyDb\V1beta\GetInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetInstance(\Google\Cloud\AlloyDb\V1beta\GetInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/GetInstance',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\Instance', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Instance in a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\CreateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateInstance(\Google\Cloud\AlloyDb\V1beta\CreateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/CreateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new SECONDARY Instance in a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\CreateSecondaryInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateSecondaryInstance(\Google\Cloud\AlloyDb\V1beta\CreateSecondaryInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/CreateSecondaryInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates new instances under the given project, location and cluster.
     * There can be only one primary instance in a cluster. If the primary
     * instance exists in the cluster as well as this request, then API will
     * throw an error.
     * The primary instance should exist before any read pool instance is
     * created. If the primary instance is a part of the request payload, then
     * the API will take care of creating instances in the correct order.
     * This method is here to support Google-internal use cases, and is not meant
     * for external customers to consume. Please do not start relying on it; its
     * behavior is subject to change without notice.
     * @param \Google\Cloud\AlloyDb\V1beta\BatchCreateInstancesRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function BatchCreateInstances(\Google\Cloud\AlloyDb\V1beta\BatchCreateInstancesRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/BatchCreateInstances',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Instance.
     * @param \Google\Cloud\AlloyDb\V1beta\UpdateInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateInstance(\Google\Cloud\AlloyDb\V1beta\UpdateInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/UpdateInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Instance.
     * @param \Google\Cloud\AlloyDb\V1beta\DeleteInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteInstance(\Google\Cloud\AlloyDb\V1beta\DeleteInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/DeleteInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Forces a Failover for a highly available instance.
     * Failover promotes the HA standby instance as the new primary.
     * Imperative only.
     * @param \Google\Cloud\AlloyDb\V1beta\FailoverInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function FailoverInstance(\Google\Cloud\AlloyDb\V1beta\FailoverInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/FailoverInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restart an Instance in a cluster.
     * Imperative only.
     * @param \Google\Cloud\AlloyDb\V1beta\RestartInstanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestartInstance(\Google\Cloud\AlloyDb\V1beta\RestartInstanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/RestartInstance',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists Backups in a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\ListBackupsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListBackups(\Google\Cloud\AlloyDb\V1beta\ListBackupsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/ListBackups',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\ListBackupsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Gets details of a single Backup.
     * @param \Google\Cloud\AlloyDb\V1beta\GetBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetBackup(\Google\Cloud\AlloyDb\V1beta\GetBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/GetBackup',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\Backup', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Backup in a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\CreateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateBackup(\Google\Cloud\AlloyDb\V1beta\CreateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/CreateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates the parameters of a single Backup.
     * @param \Google\Cloud\AlloyDb\V1beta\UpdateBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function UpdateBackup(\Google\Cloud\AlloyDb\V1beta\UpdateBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/UpdateBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a single Backup.
     * @param \Google\Cloud\AlloyDb\V1beta\DeleteBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DeleteBackup(\Google\Cloud\AlloyDb\V1beta\DeleteBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/DeleteBackup',
        $argument,
        ['\Google\LongRunning\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists SupportedDatabaseFlags for a given project and location.
     * @param \Google\Cloud\AlloyDb\V1beta\ListSupportedDatabaseFlagsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListSupportedDatabaseFlags(\Google\Cloud\AlloyDb\V1beta\ListSupportedDatabaseFlagsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/ListSupportedDatabaseFlags',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\ListSupportedDatabaseFlagsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Generate a client certificate signed by a Cluster CA.
     * The sole purpose of this endpoint is to support the Auth Proxy client and
     * the endpoint's behavior is subject to change without notice, so do not rely
     * on its behavior remaining constant. Future changes will not break the Auth
     * Proxy client.
     * @param \Google\Cloud\AlloyDb\V1beta\GenerateClientCertificateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GenerateClientCertificate(\Google\Cloud\AlloyDb\V1beta\GenerateClientCertificateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/GenerateClientCertificate',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\GenerateClientCertificateResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Get instance metadata used for a connection.
     * @param \Google\Cloud\AlloyDb\V1beta\GetConnectionInfoRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function GetConnectionInfo(\Google\Cloud\AlloyDb\V1beta\GetConnectionInfoRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.alloydb.v1beta.AlloyDBAdmin/GetConnectionInfo',
        $argument,
        ['\Google\Cloud\AlloyDb\V1beta\ConnectionInfo', 'decode'],
        $metadata, $options);
    }

}
