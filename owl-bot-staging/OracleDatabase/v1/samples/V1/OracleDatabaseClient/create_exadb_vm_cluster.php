<?php
/*
 * Copyright 2025 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

// [START oracledatabase_v1_generated_OracleDatabase_CreateExadbVmCluster_sync]
use Google\ApiCore\ApiException;
use Google\ApiCore\OperationResponse;
use Google\Cloud\OracleDatabase\V1\Client\OracleDatabaseClient;
use Google\Cloud\OracleDatabase\V1\CreateExadbVmClusterRequest;
use Google\Cloud\OracleDatabase\V1\ExadbVmCluster;
use Google\Cloud\OracleDatabase\V1\ExadbVmClusterProperties;
use Google\Cloud\OracleDatabase\V1\ExadbVmClusterProperties\ShapeAttribute;
use Google\Cloud\OracleDatabase\V1\ExadbVmClusterStorageDetails;
use Google\Rpc\Status;

/**
 * Creates a new Exadb (Exascale) VM Cluster resource.
 *
 * @param string $formattedParent                                             The value for parent of the ExadbVmCluster in the following
 *                                                                            format: projects/{project}/locations/{location}. Please see
 *                                                                            {@see OracleDatabaseClient::locationName()} for help formatting this field.
 * @param string $exadbVmClusterId                                            The ID of the ExadbVmCluster to create. This value is
 *                                                                            restricted to (^[a-z]([a-z0-9-]{0,61}[a-z0-9])?$) and must be a maximum of
 *                                                                            63 characters in length. The value must start with a letter and end with a
 *                                                                            letter or a number.
 * @param string $exadbVmClusterPropertiesGridImageId                         Immutable. Grid Infrastructure Version.
 * @param int    $exadbVmClusterPropertiesNodeCount                           The number of nodes/VMs in the ExadbVmCluster.
 * @param int    $exadbVmClusterPropertiesEnabledEcpuCountPerNode             Immutable. The number of ECPUs enabled per node for an exadata vm
 *                                                                            cluster on exascale infrastructure.
 * @param int    $exadbVmClusterPropertiesVmFileSystemStorageSizeInGbsPerNode The storage allocation for the exadbvmcluster per node, in
 *                                                                            gigabytes (GB). This field is used to calculate the total storage
 *                                                                            allocation for the exadbvmcluster.
 * @param string $formattedExadbVmClusterPropertiesExascaleDbStorageVault     Immutable. The name of ExascaleDbStorageVault associated with the
 *                                                                            ExadbVmCluster. It can refer to an existing ExascaleDbStorageVault. Or a
 *                                                                            new one can be created during the ExadbVmCluster creation (requires
 *                                                                            storage_vault_properties to be set).
 *                                                                            Format:
 *                                                                            projects/{project}/locations/{location}/exascaleDbStorageVaults/{exascale_db_storage_vault}
 *                                                                            Please see {@see OracleDatabaseClient::exascaleDbStorageVaultName()} for help formatting this field.
 * @param string $exadbVmClusterPropertiesHostnamePrefix                      Immutable. Prefix for VM cluster host names.
 * @param string $exadbVmClusterPropertiesSshPublicKeysElement                Immutable. The SSH public keys for the ExadbVmCluster.
 * @param int    $exadbVmClusterPropertiesShapeAttribute                      Immutable. The shape attribute of the VM cluster. The type of
 *                                                                            Exascale storage used for Exadata VM cluster. The default is SMART_STORAGE
 *                                                                            which supports Oracle Database 23ai and later
 * @param string $formattedExadbVmClusterOdbSubnet                            Immutable. The name of the OdbSubnet associated with the
 *                                                                            ExadbVmCluster for IP allocation. Format:
 *                                                                            projects/{project}/locations/{location}/odbNetworks/{odb_network}/odbSubnets/{odb_subnet}
 *                                                                            Please see {@see OracleDatabaseClient::odbSubnetName()} for help formatting this field.
 * @param string $formattedExadbVmClusterBackupOdbSubnet                      Immutable. The name of the backup OdbSubnet associated with the
 *                                                                            ExadbVmCluster. Format:
 *                                                                            projects/{project}/locations/{location}/odbNetworks/{odb_network}/odbSubnets/{odb_subnet}
 *                                                                            Please see {@see OracleDatabaseClient::odbSubnetName()} for help formatting this field.
 * @param string $exadbVmClusterDisplayName                                   Immutable. The display name for the ExadbVmCluster. The name does
 *                                                                            not have to be unique within your project. The name must be 1-255
 *                                                                            characters long and can only contain alphanumeric characters.
 */
function create_exadb_vm_cluster_sample(
    string $formattedParent,
    string $exadbVmClusterId,
    string $exadbVmClusterPropertiesGridImageId,
    int $exadbVmClusterPropertiesNodeCount,
    int $exadbVmClusterPropertiesEnabledEcpuCountPerNode,
    int $exadbVmClusterPropertiesVmFileSystemStorageSizeInGbsPerNode,
    string $formattedExadbVmClusterPropertiesExascaleDbStorageVault,
    string $exadbVmClusterPropertiesHostnamePrefix,
    string $exadbVmClusterPropertiesSshPublicKeysElement,
    int $exadbVmClusterPropertiesShapeAttribute,
    string $formattedExadbVmClusterOdbSubnet,
    string $formattedExadbVmClusterBackupOdbSubnet,
    string $exadbVmClusterDisplayName
): void {
    // Create a client.
    $oracleDatabaseClient = new OracleDatabaseClient();

    // Prepare the request message.
    $exadbVmClusterPropertiesVmFileSystemStorage = (new ExadbVmClusterStorageDetails())
        ->setSizeInGbsPerNode($exadbVmClusterPropertiesVmFileSystemStorageSizeInGbsPerNode);
    $exadbVmClusterPropertiesSshPublicKeys = [$exadbVmClusterPropertiesSshPublicKeysElement,];
    $exadbVmClusterProperties = (new ExadbVmClusterProperties())
        ->setGridImageId($exadbVmClusterPropertiesGridImageId)
        ->setNodeCount($exadbVmClusterPropertiesNodeCount)
        ->setEnabledEcpuCountPerNode($exadbVmClusterPropertiesEnabledEcpuCountPerNode)
        ->setVmFileSystemStorage($exadbVmClusterPropertiesVmFileSystemStorage)
        ->setExascaleDbStorageVault($formattedExadbVmClusterPropertiesExascaleDbStorageVault)
        ->setHostnamePrefix($exadbVmClusterPropertiesHostnamePrefix)
        ->setSshPublicKeys($exadbVmClusterPropertiesSshPublicKeys)
        ->setShapeAttribute($exadbVmClusterPropertiesShapeAttribute);
    $exadbVmCluster = (new ExadbVmCluster())
        ->setProperties($exadbVmClusterProperties)
        ->setOdbSubnet($formattedExadbVmClusterOdbSubnet)
        ->setBackupOdbSubnet($formattedExadbVmClusterBackupOdbSubnet)
        ->setDisplayName($exadbVmClusterDisplayName);
    $request = (new CreateExadbVmClusterRequest())
        ->setParent($formattedParent)
        ->setExadbVmClusterId($exadbVmClusterId)
        ->setExadbVmCluster($exadbVmCluster);

    // Call the API and handle any network failures.
    try {
        /** @var OperationResponse $response */
        $response = $oracleDatabaseClient->createExadbVmCluster($request);
        $response->pollUntilComplete();

        if ($response->operationSucceeded()) {
            /** @var ExadbVmCluster $result */
            $result = $response->getResult();
            printf('Operation successful with response data: %s' . PHP_EOL, $result->serializeToJsonString());
        } else {
            /** @var Status $error */
            $error = $response->getError();
            printf('Operation failed with error data: %s' . PHP_EOL, $error->serializeToJsonString());
        }
    } catch (ApiException $ex) {
        printf('Call failed with message: %s' . PHP_EOL, $ex->getMessage());
    }
}

/**
 * Helper to execute the sample.
 *
 * This sample has been automatically generated and should be regarded as a code
 * template only. It will require modifications to work:
 *  - It may require correct/in-range values for request initialization.
 *  - It may require specifying regional endpoints when creating the service client,
 *    please see the apiEndpoint client configuration option for more details.
 */
function callSample(): void
{
    $formattedParent = OracleDatabaseClient::locationName('[PROJECT]', '[LOCATION]');
    $exadbVmClusterId = '[EXADB_VM_CLUSTER_ID]';
    $exadbVmClusterPropertiesGridImageId = '[GRID_IMAGE_ID]';
    $exadbVmClusterPropertiesNodeCount = 0;
    $exadbVmClusterPropertiesEnabledEcpuCountPerNode = 0;
    $exadbVmClusterPropertiesVmFileSystemStorageSizeInGbsPerNode = 0;
    $formattedExadbVmClusterPropertiesExascaleDbStorageVault = OracleDatabaseClient::exascaleDbStorageVaultName(
        '[PROJECT]',
        '[LOCATION]',
        '[EXASCALE_DB_STORAGE_VAULT]'
    );
    $exadbVmClusterPropertiesHostnamePrefix = '[HOSTNAME_PREFIX]';
    $exadbVmClusterPropertiesSshPublicKeysElement = '[SSH_PUBLIC_KEYS]';
    $exadbVmClusterPropertiesShapeAttribute = ShapeAttribute::SHAPE_ATTRIBUTE_UNSPECIFIED;
    $formattedExadbVmClusterOdbSubnet = OracleDatabaseClient::odbSubnetName(
        '[PROJECT]',
        '[LOCATION]',
        '[ODB_NETWORK]',
        '[ODB_SUBNET]'
    );
    $formattedExadbVmClusterBackupOdbSubnet = OracleDatabaseClient::odbSubnetName(
        '[PROJECT]',
        '[LOCATION]',
        '[ODB_NETWORK]',
        '[ODB_SUBNET]'
    );
    $exadbVmClusterDisplayName = '[DISPLAY_NAME]';

    create_exadb_vm_cluster_sample(
        $formattedParent,
        $exadbVmClusterId,
        $exadbVmClusterPropertiesGridImageId,
        $exadbVmClusterPropertiesNodeCount,
        $exadbVmClusterPropertiesEnabledEcpuCountPerNode,
        $exadbVmClusterPropertiesVmFileSystemStorageSizeInGbsPerNode,
        $formattedExadbVmClusterPropertiesExascaleDbStorageVault,
        $exadbVmClusterPropertiesHostnamePrefix,
        $exadbVmClusterPropertiesSshPublicKeysElement,
        $exadbVmClusterPropertiesShapeAttribute,
        $formattedExadbVmClusterOdbSubnet,
        $formattedExadbVmClusterBackupOdbSubnet,
        $exadbVmClusterDisplayName
    );
}
// [END oracledatabase_v1_generated_OracleDatabase_CreateExadbVmCluster_sync]
