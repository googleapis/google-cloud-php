<?php

return [
    'interfaces' => [
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}:cancel',
                    ],
                ],
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
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}',
                    ],
                ],
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
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}',
                    ],
                ],
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
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.spanner.admin.database.v1.DatabaseAdmin' => [
            'CopyBackup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/backups:copy',
                'body' => '*',
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
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/backups',
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
            'CreateDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/databases',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteBackup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DropDatabase' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'GetBackup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDatabaseDdl' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/ddl',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/instances/*/databases/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/instances/*/backups/*}:getIamPolicy',
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
            'ListBackupOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/backupOperations',
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
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/backups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatabaseOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/databaseOperations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDatabaseRoles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/instances/*/databases/*}/databaseRoles',
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
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/databases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RestoreDatabase' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/instances/*}/databases:restore',
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
                'uriTemplate' => '/v1/{resource=projects/*/instances/*/databases/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/instances/*/backups/*}:setIamPolicy',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/instances/*/databases/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/instances/*/backups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/instances/*/databases/*/databaseRoles/*}:testIamPermissions',
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
            'UpdateBackup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup.name=projects/*/instances/*/backups/*}',
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
            'UpdateDatabaseDdl' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/ddl',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
