<?php

return [
    'interfaces' => [
        'google.cloud.gkebackup.v1.BackupForGKE' => [
            'CreateBackup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/backupPlans/*}/backups',
                'body' => 'backup',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateBackupPlan' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupPlans',
                'body' => 'backup_plan',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'backup_plan_id',
                ],
            ],
            'CreateRestore' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/restorePlans/*}/restores',
                'body' => 'restore',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'restore_id',
                ],
            ],
            'CreateRestorePlan' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/restorePlans',
                'body' => 'restore_plan',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'restore_plan_id',
                ],
            ],
            'DeleteBackup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupPlans/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteBackupPlan' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupPlans/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRestore' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restorePlans/*/restores/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRestorePlan' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restorePlans/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupPlans/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBackupPlan' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupPlans/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRestore' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restorePlans/*/restores/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRestorePlan' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restorePlans/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolumeBackup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupPlans/*/backups/*/volumeBackups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolumeRestore' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restorePlans/*/restores/*/volumeRestores/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBackupPlans' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupPlans',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/backupPlans/*}/backups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRestorePlans' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/restorePlans',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRestores' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/restorePlans/*}/restores',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumeBackups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/backupPlans/*/backups/*}/volumeBackups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumeRestores' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/restorePlans/*/restores/*}/volumeRestores',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateBackup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup.name=projects/*/locations/*/backupPlans/*/backups/*}',
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
            'UpdateBackupPlan' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup_plan.name=projects/*/locations/*/backupPlans/*}',
                'body' => 'backup_plan',
                'placeholders' => [
                    'backup_plan.name' => [
                        'getters' => [
                            'getBackupPlan',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRestore' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{restore.name=projects/*/locations/*/restorePlans/*/restores/*}',
                'body' => 'restore',
                'placeholders' => [
                    'restore.name' => [
                        'getters' => [
                            'getRestore',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRestorePlan' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{restore_plan.name=projects/*/locations/*/restorePlans/*}',
                'body' => 'restore_plan',
                'placeholders' => [
                    'restore_plan.name' => [
                        'getters' => [
                            'getRestorePlan',
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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*/backups/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*/backups/*/volumeBackups/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*/restores/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*/restores/*/volumeRestores/*}:getIamPolicy',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*/backups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*/backups/*/volumeBackups/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*/restores/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*/restores/*/volumeRestores/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*/backups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/backupPlans/*/backups/*/volumeBackups/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*/restores/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/restorePlans/*/restores/*/volumeRestores/*}:testIamPermissions',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
];
