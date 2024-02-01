<?php

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
        'google.cloud.netapp.v1.NetApp' => [
            'CreateActiveDirectory' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/activeDirectories',
                'body' => 'active_directory',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/backupVaults/*}/backups',
                'body' => 'backup',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateBackupPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupPolicies',
                'body' => 'backup_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateBackupVault' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupVaults',
                'body' => 'backup_vault',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateKmsConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/kmsConfigs',
                'body' => 'kms_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateReplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/volumes/*}/replications',
                'body' => 'replication',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSnapshot' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/volumes/*}/snapshots',
                'body' => 'snapshot',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateStoragePool' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/storagePools',
                'body' => 'storage_pool',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateVolume' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/volumes',
                'body' => 'volume',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteActiveDirectory' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/activeDirectories/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupVaults/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteBackupPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteBackupVault' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupVaults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteKmsConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/kmsConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteReplication' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/replications/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteStoragePool' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/storagePools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteVolume' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'EncryptVolumes' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/kmsConfigs/*}:encrypt',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetActiveDirectory' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/activeDirectories/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupVaults/*/backups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBackupPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBackupVault' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupVaults/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetKmsConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/kmsConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetReplication' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/replications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSnapshot' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetStoragePool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/storagePools/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetVolume' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListActiveDirectories' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/activeDirectories',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListBackupPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupPolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListBackupVaults' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupVaults',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/backupVaults/*}/backups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListKmsConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/kmsConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReplications' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/volumes/*}/replications',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/volumes/*}/snapshots',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListStoragePools' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/storagePools',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListVolumes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/volumes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ResumeReplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/replications/*}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ReverseReplicationDirection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/replications/*}:reverseDirection',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RevertVolume' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*}:revert',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopReplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/replications/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateActiveDirectory' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{active_directory.name=projects/*/locations/*/activeDirectories/*}',
                'body' => 'active_directory',
                'placeholders' => [
                    'active_directory.name' => [
                        'getters' => [
                            'getActiveDirectory',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateBackup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup.name=projects/*/locations/*/backupVaults/*/backups/*}',
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
            'UpdateBackupPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup_policy.name=projects/*/locations/*/backupPolicies/*}',
                'body' => 'backup_policy',
                'placeholders' => [
                    'backup_policy.name' => [
                        'getters' => [
                            'getBackupPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateBackupVault' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup_vault.name=projects/*/locations/*/backupVaults/*}',
                'body' => 'backup_vault',
                'placeholders' => [
                    'backup_vault.name' => [
                        'getters' => [
                            'getBackupVault',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateKmsConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{kms_config.name=projects/*/locations/*/kmsConfigs/*}',
                'body' => 'kms_config',
                'placeholders' => [
                    'kms_config.name' => [
                        'getters' => [
                            'getKmsConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateReplication' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{replication.name=projects/*/locations/*/volumes/*/replications/*}',
                'body' => 'replication',
                'placeholders' => [
                    'replication.name' => [
                        'getters' => [
                            'getReplication',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSnapshot' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{snapshot.name=projects/*/locations/*/volumes/*/snapshots/*}',
                'body' => 'snapshot',
                'placeholders' => [
                    'snapshot.name' => [
                        'getters' => [
                            'getSnapshot',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateStoragePool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{storage_pool.name=projects/*/locations/*/storagePools/*}',
                'body' => 'storage_pool',
                'placeholders' => [
                    'storage_pool.name' => [
                        'getters' => [
                            'getStoragePool',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateVolume' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{volume.name=projects/*/locations/*/volumes/*}',
                'body' => 'volume',
                'placeholders' => [
                    'volume.name' => [
                        'getters' => [
                            'getVolume',
                            'getName',
                        ],
                    ],
                ],
            ],
            'VerifyKmsConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/kmsConfigs/*}:verify',
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
