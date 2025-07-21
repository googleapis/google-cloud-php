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
            'ListDbNodes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/cloudVmClusters/*}/dbNodes',
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
