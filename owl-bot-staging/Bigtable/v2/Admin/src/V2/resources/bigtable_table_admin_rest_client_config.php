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
        'google.bigtable.admin.v2.BigtableTableAdmin' => [
            'CheckConsistency' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}:checkConsistency',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CopyBackup' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/clusters/*}/backups:copy',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAuthorizedView' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/tables/*}/authorizedViews',
                'body' => 'authorized_view',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'authorized_view_id',
                ],
            ],
            'CreateBackup' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/clusters/*}/backups',
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
            'CreateTable' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/tables',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTableFromSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/tables:createFromSnapshot',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAuthorizedView' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*/authorizedViews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteBackup' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSnapshot' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTable' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DropRowRange' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}:dropRowRange',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateConsistencyToken' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}:generateConsistencyToken',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAuthorizedView' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*/authorizedViews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBackup' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*/tables/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/clusters/*/backups/*}:getIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetSnapshot' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/clusters/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTable' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAuthorizedViews' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/tables/*}/authorizedViews',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListBackups' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/clusters/*}/backups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSnapshots' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*/clusters/*}/snapshots',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTables' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/tables',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ModifyColumnFamilies' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}:modifyColumnFamilies',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestoreTable' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/instances/*}/tables:restore',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*/tables/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/clusters/*/backups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SnapshotTable' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}:snapshot',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/instances/*/tables/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{resource=projects/*/instances/*/clusters/*/backups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UndeleteTable' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*/tables/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAuthorizedView' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{authorized_view.name=projects/*/instances/*/tables/*/authorizedViews/*}',
                'body' => 'authorized_view',
                'placeholders' => [
                    'authorized_view.name' => [
                        'getters' => [
                            'getAuthorizedView',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateBackup' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{backup.name=projects/*/instances/*/clusters/*/backups/*}',
                'body' => 'backup',
                'placeholders' => [
                    'backup.name' => [
                        'getters' => [
                            'getBackup',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTable' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{table.name=projects/*/instances/*/tables/*}',
                'body' => 'table',
                'placeholders' => [
                    'table.name' => [
                        'getters' => [
                            'getTable',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=operations/**}:cancel',
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
                'uriTemplate' => '/v2/{name=operations/**}',
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
                'uriTemplate' => '/v2/{name=operations/**}',
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
                'uriTemplate' => '/v2/{name=operations/projects/**}/operations',
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
