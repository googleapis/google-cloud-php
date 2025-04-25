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
            'CreateBackupChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupChannels',
                'body' => 'backup_channel',
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
            'CreateRestoreChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/restoreChannels',
                'body' => 'restore_channel',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
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
            'DeleteBackupChannel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupChannels/*}',
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
            'DeleteRestoreChannel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restoreChannels/*}',
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
            'GetBackupChannel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupChannels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBackupIndexDownloadUrl' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{backup=projects/*/locations/*/backupPlans/*/backups/*}:getBackupIndexDownloadUrl',
                'placeholders' => [
                    'backup' => [
                        'getters' => [
                            'getBackup',
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
            'GetBackupPlanBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/backupChannels/*/backupPlanBindings/*}',
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
            'GetRestoreChannel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restoreChannels/*}',
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
            'GetRestorePlanBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/restoreChannels/*/restorePlanBindings/*}',
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
            'ListBackupChannels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/backupChannels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListBackupPlanBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/backupChannels/*}/backupPlanBindings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
            'ListRestoreChannels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/restoreChannels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRestorePlanBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/restoreChannels/*}/restorePlanBindings',
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
            'UpdateBackupChannel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{backup_channel.name=projects/*/locations/*/backupChannels/*}',
                'body' => 'backup_channel',
                'placeholders' => [
                    'backup_channel.name' => [
                        'getters' => [
                            'getBackupChannel',
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
            'UpdateRestoreChannel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{restore_channel.name=projects/*/locations/*/restoreChannels/*}',
                'body' => 'restore_channel',
                'placeholders' => [
                    'restore_channel.name' => [
                        'getters' => [
                            'getRestoreChannel',
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
