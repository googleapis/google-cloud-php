<?php
/*
 * Copyright 2024 Google LLC
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

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.oracledatabase.v1.OracleDatabase' => [
            'CreateAutonomousDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/autonomousDatabases',
                'body' => 'autonomous_database',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'autonomous_database_id',
                ],
            ],
            'CreateCloudExadataInfrastructure' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/cloudExadataInfrastructures',
                'body' => 'cloud_exadata_infrastructure',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cloud_exadata_infrastructure_id',
                ],
            ],
            'CreateCloudVmCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/cloudVmClusters',
                'body' => 'cloud_vm_cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cloud_vm_cluster_id',
                ],
            ],
            'CreateDbSystem' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dbSystems',
                'body' => 'db_system',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'db_system_id',
                ],
            ],
            'CreateExadbVmCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/exadbVmClusters',
                'body' => 'exadb_vm_cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'exadb_vm_cluster_id',
                ],
            ],
            'CreateExascaleDbStorageVault' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/exascaleDbStorageVaults',
                'body' => 'exascale_db_storage_vault',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'exascale_db_storage_vault_id',
                ],
            ],
            'CreateOdbNetwork' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/odbNetworks',
                'body' => 'odb_network',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'odb_network_id',
                ],
            ],
            'CreateOdbSubnet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/odbNetworks/*}/odbSubnets',
                'body' => 'odb_subnet',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'odb_subnet_id',
                ],
            ],
            'DeleteAutonomousDatabase' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCloudExadataInfrastructure' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/cloudExadataInfrastructures/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCloudVmCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/cloudVmClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteDbSystem' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dbSystems/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExadbVmCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/exadbVmClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteExascaleDbStorageVault' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/exascaleDbStorageVaults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOdbNetwork' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/odbNetworks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOdbSubnet' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/odbNetworks/*/odbSubnets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FailoverAutonomousDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}:failover',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateAutonomousDatabaseWallet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}:generateWallet',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAutonomousDatabase' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCloudExadataInfrastructure' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/cloudExadataInfrastructures/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCloudVmCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/cloudVmClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDatabase' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/databases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDbSystem' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/dbSystems/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExadbVmCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/exadbVmClusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetExascaleDbStorageVault' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/exascaleDbStorageVaults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOdbNetwork' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/odbNetworks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOdbSubnet' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/odbNetworks/*/odbSubnets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPluggableDatabase' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/pluggableDatabases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAutonomousDatabaseBackups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/autonomousDatabaseBackups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAutonomousDatabaseCharacterSets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/autonomousDatabaseCharacterSets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAutonomousDatabases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/autonomousDatabases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAutonomousDbVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/autonomousDbVersions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCloudExadataInfrastructures' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/cloudExadataInfrastructures',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCloudVmClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/cloudVmClusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatabaseCharacterSets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/databaseCharacterSets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatabases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/databases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDbNodes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/cloudVmClusters/*}/dbNodes',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/exadbVmClusters/*}/dbNodes',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDbServers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/cloudExadataInfrastructures/*}/dbServers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDbSystemInitialStorageSizes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dbSystemInitialStorageSizes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDbSystemShapes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dbSystemShapes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDbSystems' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dbSystems',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDbVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/dbVersions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEntitlements' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/entitlements',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExadbVmClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/exadbVmClusters',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListExascaleDbStorageVaults' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/exascaleDbStorageVaults',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGiVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/giVersions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMinorVersions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/giVersions/*}/minorVersions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOdbNetworks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/odbNetworks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOdbSubnets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/odbNetworks/*}/odbSubnets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPluggableDatabases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/pluggableDatabases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveVirtualMachineExadbVmCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/exadbVmClusters/*}:removeVirtualMachine',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestartAutonomousDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}:restart',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestoreAutonomousDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}:restore',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StartAutonomousDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopAutonomousDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SwitchoverAutonomousDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/autonomousDatabases/*}:switchover',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAutonomousDatabase' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{autonomous_database.name=projects/*/locations/*/autonomousDatabases/*}',
                'body' => 'autonomous_database',
                'placeholders' => [
                    'autonomous_database.name' => [
                        'getters' => [
                            'getAutonomousDatabase',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateExadbVmCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{exadb_vm_cluster.name=projects/*/locations/*/exadbVmClusters/*}',
                'body' => 'exadb_vm_cluster',
                'placeholders' => [
                    'exadb_vm_cluster.name' => [
                        'getters' => [
                            'getExadbVmCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
