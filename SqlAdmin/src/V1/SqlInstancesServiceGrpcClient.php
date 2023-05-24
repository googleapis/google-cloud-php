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
namespace Google\Cloud\Sql\V1;

/**
 * LINT: LEGACY_NAMES
 *
 * Service to manage Cloud SQL instances.
 */
class SqlInstancesServiceGrpcClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Adds a new trusted Certificate Authority (CA) version for the specified
     * instance. Required to prepare for a certificate rotation. If a CA version
     * was previously added but never used in a certificate rotation, this
     * operation replaces that version. There cannot be more than one CA version
     * waiting to be rotated in.
     * @param \Google\Cloud\Sql\V1\SqlInstancesAddServerCaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddServerCa(\Google\Cloud\Sql\V1\SqlInstancesAddServerCaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/AddServerCa',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Cloud SQL instance as a clone of the source instance. Using this
     * operation might cause your instance to restart.
     * @param \Google\Cloud\Sql\V1\SqlInstancesCloneRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Clone(\Google\Cloud\Sql\V1\SqlInstancesCloneRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Clone',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Google\Cloud\Sql\V1\SqlInstancesDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Delete',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Demotes the stand-alone instance to be a Cloud SQL read replica for an
     * external database server.
     * @param \Google\Cloud\Sql\V1\SqlInstancesDemoteMasterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DemoteMaster(\Google\Cloud\Sql\V1\SqlInstancesDemoteMasterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/DemoteMaster',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports data from a Cloud SQL instance to a Cloud Storage bucket as a SQL
     * dump or CSV file.
     * @param \Google\Cloud\Sql\V1\SqlInstancesExportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Export(\Google\Cloud\Sql\V1\SqlInstancesExportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Export',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Initiates a manual failover of a high availability (HA) primary instance
     * to a standby instance, which becomes the primary instance. Users are
     * then rerouted to the new primary. For more information, see the
     * [Overview of high
     * availability](https://cloud.google.com/sql/docs/mysql/high-availability)
     * page in the Cloud SQL documentation.
     * If using Legacy HA (MySQL only), this causes the instance to failover to
     * its failover replica instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesFailoverRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Failover(\Google\Cloud\Sql\V1\SqlInstancesFailoverRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Failover',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a resource containing information about a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesGetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Get(\Google\Cloud\Sql\V1\SqlInstancesGetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Get',
        $argument,
        ['\Google\Cloud\Sql\V1\DatabaseInstance', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports data into a Cloud SQL instance from a SQL dump  or CSV file in
     * Cloud Storage.
     * @param \Google\Cloud\Sql\V1\SqlInstancesImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Import(\Google\Cloud\Sql\V1\SqlInstancesImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Import',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesInsertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Insert(\Google\Cloud\Sql\V1\SqlInstancesInsertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Insert',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists instances under a given project.
     * @param \Google\Cloud\Sql\V1\SqlInstancesListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function List(\Google\Cloud\Sql\V1\SqlInstancesListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/List',
        $argument,
        ['\Google\Cloud\Sql\V1\InstancesListResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all of the trusted Certificate Authorities (CAs) for the specified
     * instance. There can be up to three CAs listed: the CA that was used to sign
     * the certificate that is currently in use, a CA that has been added but not
     * yet used to sign a certificate, and a CA used to sign a certificate that
     * has previously rotated out.
     * @param \Google\Cloud\Sql\V1\SqlInstancesListServerCasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServerCas(\Google\Cloud\Sql\V1\SqlInstancesListServerCasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/ListServerCas',
        $argument,
        ['\Google\Cloud\Sql\V1\InstancesListServerCasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates settings of a Cloud SQL instance.
     * This method supports patch semantics.
     * @param \Google\Cloud\Sql\V1\SqlInstancesPatchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Patch(\Google\Cloud\Sql\V1\SqlInstancesPatchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Patch',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Promotes the read replica instance to be a stand-alone Cloud SQL instance.
     * Using this operation might cause your instance to restart.
     * @param \Google\Cloud\Sql\V1\SqlInstancesPromoteReplicaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PromoteReplica(\Google\Cloud\Sql\V1\SqlInstancesPromoteReplicaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/PromoteReplica',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes all client certificates and generates a new server SSL certificate
     * for the instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesResetSslConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetSslConfig(\Google\Cloud\Sql\V1\SqlInstancesResetSslConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/ResetSslConfig',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restarts a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesRestartRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Restart(\Google\Cloud\Sql\V1\SqlInstancesRestartRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Restart',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restores a backup of a Cloud SQL instance. Using this operation might cause
     * your instance to restart.
     * @param \Google\Cloud\Sql\V1\SqlInstancesRestoreBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreBackup(\Google\Cloud\Sql\V1\SqlInstancesRestoreBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/RestoreBackup',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Rotates the server certificate to one signed by the Certificate Authority
     * (CA) version previously added with the addServerCA method.
     * @param \Google\Cloud\Sql\V1\SqlInstancesRotateServerCaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RotateServerCa(\Google\Cloud\Sql\V1\SqlInstancesRotateServerCaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/RotateServerCa',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts the replication in the read replica instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesStartReplicaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartReplica(\Google\Cloud\Sql\V1\SqlInstancesStartReplicaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/StartReplica',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops the replication in the read replica instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesStopReplicaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopReplica(\Google\Cloud\Sql\V1\SqlInstancesStopReplicaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/StopReplica',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Truncate MySQL general and slow query log tables
     * MySQL only.
     * @param \Google\Cloud\Sql\V1\SqlInstancesTruncateLogRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TruncateLog(\Google\Cloud\Sql\V1\SqlInstancesTruncateLogRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/TruncateLog',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates settings of a Cloud SQL instance. Using this operation might cause
     * your instance to restart.
     * @param \Google\Cloud\Sql\V1\SqlInstancesUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Update(\Google\Cloud\Sql\V1\SqlInstancesUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/Update',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates a short-lived X509 certificate containing the provided public key
     * and signed by a private key specific to the target instance. Users may use
     * the certificate to authenticate as themselves when connecting to the
     * database.
     * @param \Google\Cloud\Sql\V1\SqlInstancesCreateEphemeralCertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEphemeral(\Google\Cloud\Sql\V1\SqlInstancesCreateEphemeralCertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/CreateEphemeral',
        $argument,
        ['\Google\Cloud\Sql\V1\SslCert', 'decode'],
        $metadata, $options);
    }

    /**
     * Reschedules the maintenance on the given instance.
     * @param \Google\Cloud\Sql\V1\SqlInstancesRescheduleMaintenanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RescheduleMaintenance(\Google\Cloud\Sql\V1\SqlInstancesRescheduleMaintenanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/RescheduleMaintenance',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Verify External primary instance external sync settings.
     * @param \Google\Cloud\Sql\V1\SqlInstancesVerifyExternalSyncSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function VerifyExternalSyncSettings(\Google\Cloud\Sql\V1\SqlInstancesVerifyExternalSyncSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/VerifyExternalSyncSettings',
        $argument,
        ['\Google\Cloud\Sql\V1\SqlInstancesVerifyExternalSyncSettingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Start External primary instance migration.
     * @param \Google\Cloud\Sql\V1\SqlInstancesStartExternalSyncRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartExternalSync(\Google\Cloud\Sql\V1\SqlInstancesStartExternalSyncRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1.SqlInstancesService/StartExternalSync',
        $argument,
        ['\Google\Cloud\Sql\V1\Operation', 'decode'],
        $metadata, $options);
    }

}
