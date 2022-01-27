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
namespace Google\Cloud\Sql\V1beta4;

/**
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
     * Add a new trusted Certificate Authority (CA) version for the specified
     * instance. Required to prepare for a certificate rotation. If a CA version
     * was previously added but never used in a certificate rotation, this
     * operation replaces that version. There cannot be more than one CA version
     * waiting to be rotated in.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesAddServerCaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function AddServerCa(\Google\Cloud\Sql\V1beta4\SqlInstancesAddServerCaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/AddServerCa',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a Cloud SQL instance as a clone of the source instance. Using this
     * operation might cause your instance to restart.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesCloneRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Clone(\Google\Cloud\Sql\V1beta4\SqlInstancesCloneRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Clone',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesDeleteRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Delete(\Google\Cloud\Sql\V1beta4\SqlInstancesDeleteRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Delete',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Demotes the stand-alone instance to be a Cloud SQL read replica for an
     * external database server.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesDemoteMasterRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function DemoteMaster(\Google\Cloud\Sql\V1beta4\SqlInstancesDemoteMasterRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/DemoteMaster',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Exports data from a Cloud SQL instance to a Cloud Storage bucket as a SQL
     * dump or CSV file.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesExportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Export(\Google\Cloud\Sql\V1beta4\SqlInstancesExportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Export',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
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
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesFailoverRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Failover(\Google\Cloud\Sql\V1beta4\SqlInstancesFailoverRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Failover',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Retrieves a resource containing information about a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesGetRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Get(\Google\Cloud\Sql\V1beta4\SqlInstancesGetRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Get',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\DatabaseInstance', 'decode'],
        $metadata, $options);
    }

    /**
     * Imports data into a Cloud SQL instance from a SQL dump  or CSV file in
     * Cloud Storage.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesImportRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Import(\Google\Cloud\Sql\V1beta4\SqlInstancesImportRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Import',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Creates a new Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesInsertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Insert(\Google\Cloud\Sql\V1beta4\SqlInstancesInsertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Insert',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists instances under a given project.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesListRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function List(\Google\Cloud\Sql\V1beta4\SqlInstancesListRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/List',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\InstancesListResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Lists all of the trusted Certificate Authorities (CAs) for the specified
     * instance. There can be up to three CAs listed: the CA that was used to sign
     * the certificate that is currently in use, a CA that has been added but not
     * yet used to sign a certificate, and a CA used to sign a certificate that
     * has previously rotated out.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesListServerCasRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ListServerCas(\Google\Cloud\Sql\V1beta4\SqlInstancesListServerCasRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/ListServerCas',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\InstancesListServerCasResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates settings of a Cloud SQL instance.
     * This method supports patch semantics.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesPatchRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Patch(\Google\Cloud\Sql\V1beta4\SqlInstancesPatchRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Patch',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Promotes the read replica instance to be a stand-alone Cloud SQL instance.
     * Using this operation might cause your instance to restart.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesPromoteReplicaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function PromoteReplica(\Google\Cloud\Sql\V1beta4\SqlInstancesPromoteReplicaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/PromoteReplica',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Deletes all client certificates and generates a new server SSL certificate
     * for the instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesResetSslConfigRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function ResetSslConfig(\Google\Cloud\Sql\V1beta4\SqlInstancesResetSslConfigRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/ResetSslConfig',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restarts a Cloud SQL instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesRestartRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Restart(\Google\Cloud\Sql\V1beta4\SqlInstancesRestartRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Restart',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Restores a backup of a Cloud SQL instance. Using this operation might cause
     * your instance to restart.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesRestoreBackupRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RestoreBackup(\Google\Cloud\Sql\V1beta4\SqlInstancesRestoreBackupRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/RestoreBackup',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Rotates the server certificate to one signed by the Certificate Authority
     * (CA) version previously added with the addServerCA method.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesRotateServerCaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RotateServerCa(\Google\Cloud\Sql\V1beta4\SqlInstancesRotateServerCaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/RotateServerCa',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Starts the replication in the read replica instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesStartReplicaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartReplica(\Google\Cloud\Sql\V1beta4\SqlInstancesStartReplicaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/StartReplica',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Stops the replication in the read replica instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesStopReplicaRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StopReplica(\Google\Cloud\Sql\V1beta4\SqlInstancesStopReplicaRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/StopReplica',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Truncate MySQL general and slow query log tables
     * MySQL only.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesTruncateLogRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function TruncateLog(\Google\Cloud\Sql\V1beta4\SqlInstancesTruncateLogRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/TruncateLog',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Updates settings of a Cloud SQL instance. Using this operation might cause
     * your instance to restart.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesUpdateRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function Update(\Google\Cloud\Sql\V1beta4\SqlInstancesUpdateRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/Update',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Generates a short-lived X509 certificate containing the provided public key
     * and signed by a private key specific to the target instance. Users may use
     * the certificate to authenticate as themselves when connecting to the
     * database.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesCreateEphemeralCertRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function CreateEphemeral(\Google\Cloud\Sql\V1beta4\SqlInstancesCreateEphemeralCertRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/CreateEphemeral',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\SslCert', 'decode'],
        $metadata, $options);
    }

    /**
     * Reschedules the maintenance on the given instance.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesRescheduleMaintenanceRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function RescheduleMaintenance(\Google\Cloud\Sql\V1beta4\SqlInstancesRescheduleMaintenanceRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/RescheduleMaintenance',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

    /**
     * Verify External primary instance external sync settings.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesVerifyExternalSyncSettingsRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function VerifyExternalSyncSettings(\Google\Cloud\Sql\V1beta4\SqlInstancesVerifyExternalSyncSettingsRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/VerifyExternalSyncSettings',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\SqlInstancesVerifyExternalSyncSettingsResponse', 'decode'],
        $metadata, $options);
    }

    /**
     * Start External primary instance migration.
     * @param \Google\Cloud\Sql\V1beta4\SqlInstancesStartExternalSyncRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Grpc\UnaryCall
     */
    public function StartExternalSync(\Google\Cloud\Sql\V1beta4\SqlInstancesStartExternalSyncRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/google.cloud.sql.v1beta4.SqlInstancesService/StartExternalSync',
        $argument,
        ['\Google\Cloud\Sql\V1beta4\Operation', 'decode'],
        $metadata, $options);
    }

}
