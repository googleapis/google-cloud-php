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
        'google.cloud.alloydb.v1.AlloyDBAdmin' => [
            'BatchCreateInstances' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/instances:batchCreate',
                'body' => 'requests',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateBackup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backups',
                'body' => 'backup',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'backup_id',
                ],
            ],
            'CreateCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters',
                'body' => 'cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cluster_id',
                ],
            ],
            'CreateInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/instances',
                'body' => 'instance',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'instance_id',
                ],
            ],
            'CreateSecondaryCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters:createsecondary',
                'body' => 'cluster',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSecondaryInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/instances:createsecondary',
                'body' => 'instance',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateUser' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/users',
                'body' => 'user',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'user_id',
                ],
            ],
            'DeleteBackup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteCluster' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteInstance' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUser' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/users/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExecuteSql' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{instance=projects/*/locations/*/clusters/*/instances/*}:executeSql',
                'body' => '*',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                ],
            ],
            'ExportCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:export',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FailoverInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/instances/*}:failover',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateClientCertificate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}:generateClientCertificate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetBackup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCluster' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConnectionInfo' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*/instances/*}/connectionInfo',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUser' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/users/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:import',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InjectFault' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/instances/*}:injectFault',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBackups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListClusters' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/databases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSupportedDatabaseFlags' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/supportedDatabaseFlags',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUsers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/clusters/*}/users',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PromoteCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:promote',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestartInstance' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*/instances/*}:restart',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestoreCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/clusters:restore',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SwitchoverCluster' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:switchover',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateBackup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup.name=projects/*/locations/*/backups/*}',
                'body' => 'backup',
                'placeholders' => [
                    'backup.name' => [
                        'getters' => [
                            'getBackup',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{cluster.name=projects/*/locations/*/clusters/*}',
                'body' => 'cluster',
                'placeholders' => [
                    'cluster.name' => [
                        'getters' => [
                            'getCluster',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{instance.name=projects/*/locations/*/clusters/*/instances/*}',
                'body' => 'instance',
                'placeholders' => [
                    'instance.name' => [
                        'getters' => [
                            'getInstance',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateUser' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{user.name=projects/*/locations/*/clusters/*/users/*}',
                'body' => 'user',
                'placeholders' => [
                    'user.name' => [
                        'getters' => [
                            'getUser',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpgradeCluster' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/clusters/*}:upgrade',
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
