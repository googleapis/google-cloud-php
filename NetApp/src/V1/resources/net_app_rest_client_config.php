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
                'queryParams' => [
                    'active_directory_id',
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
                'queryParams' => [
                    'backup_id',
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
                'queryParams' => [
                    'backup_policy_id',
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
                'queryParams' => [
                    'backup_vault_id',
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
                'queryParams' => [
                    'kms_config_id',
                ],
            ],
            'CreateQuotaRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/volumes/*}/quotaRules',
                'body' => 'quota_rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'quota_rule_id',
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
                'queryParams' => [
                    'replication_id',
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
                'queryParams' => [
                    'snapshot_id',
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
                'queryParams' => [
                    'storage_pool_id',
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
                'queryParams' => [
                    'volume_id',
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
            'DeleteQuotaRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/quotaRules/*}',
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
            'EstablishPeering' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/replications/*}:establishPeering',
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
            'GetQuotaRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/quotaRules/*}',
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
            'ListQuotaRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/volumes/*}/quotaRules',
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
            'SwitchActiveReplicaZone' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/storagePools/*}:switch',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SyncReplication' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/volumes/*/replications/*}:sync',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateQuotaRule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{quota_rule.name=projects/*/locations/*/volumes/*/quotaRules/*}',
                'body' => 'quota_rule',
                'placeholders' => [
                    'quota_rule.name' => [
                        'getters' => [
                            'getQuotaRule',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'ValidateDirectoryService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/storagePools/*}:validateDirectoryService',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
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
