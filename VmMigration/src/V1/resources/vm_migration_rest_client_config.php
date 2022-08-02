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
        'google.cloud.vmmigration.v1.VmMigration' => [
            'AddGroupMigration' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{group=projects/*/locations/*/groups/*}:addGroupMigration',
                'body' => '*',
                'placeholders' => [
                    'group' => [
                        'getters' => [
                            'getGroup',
                        ],
                    ],
                ],
            ],
            'CancelCloneJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/migratingVms/*/cloneJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelCutoverJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/migratingVms/*/cutoverJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateCloneJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*/migratingVms/*}/cloneJobs',
                'body' => 'clone_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'clone_job_id',
                ],
            ],
            'CreateCutoverJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*/migratingVms/*}/cutoverJobs',
                'body' => 'cutover_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'cutover_job_id',
                ],
            ],
            'CreateDatacenterConnector' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*}/datacenterConnectors',
                'body' => 'datacenter_connector',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'datacenter_connector_id',
                ],
            ],
            'CreateGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/groups',
                'body' => 'group',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'group_id',
                ],
            ],
            'CreateMigratingVm' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*}/migratingVms',
                'body' => 'migrating_vm',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'migrating_vm_id',
                ],
            ],
            'CreateSource' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/sources',
                'body' => 'source',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'source_id',
                ],
            ],
            'CreateTargetProject' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/targetProjects',
                'body' => 'target_project',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'target_project_id',
                ],
            ],
            'CreateUtilizationReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*}/utilizationReports',
                'body' => 'utilization_report',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'utilization_report_id',
                ],
            ],
            'DeleteDatacenterConnector' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/datacenterConnectors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGroup' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMigratingVm' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/migratingVms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSource' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTargetProject' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/targetProjects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteUtilizationReport' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/utilizationReports/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FetchInventory' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{source=projects/*/locations/*/sources/*}:fetchInventory',
                'placeholders' => [
                    'source' => [
                        'getters' => [
                            'getSource',
                        ],
                    ],
                ],
            ],
            'FinalizeMigration' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{migrating_vm=projects/*/locations/*/sources/*/migratingVms/*}:finalizeMigration',
                'body' => '*',
                'placeholders' => [
                    'migrating_vm' => [
                        'getters' => [
                            'getMigratingVm',
                        ],
                    ],
                ],
            ],
            'GetCloneJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/migratingVms/*/cloneJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCutoverJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/migratingVms/*/cutoverJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDatacenterConnector' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/datacenterConnectors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGroup' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/groups/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMigratingVm' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/migratingVms/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSource' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTargetProject' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/targetProjects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetUtilizationReport' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/utilizationReports/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCloneJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*/migratingVms/*}/cloneJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'ListCutoverJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*/migratingVms/*}/cutoverJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'ListDatacenterConnectors' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*}/datacenterConnectors',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'ListGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/groups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'ListMigratingVms' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*}/migratingVms',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'ListSources' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/sources',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'ListTargetProjects' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/targetProjects',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'ListUtilizationReports' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*}/utilizationReports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_token',
                ],
            ],
            'PauseMigration' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{migrating_vm=projects/*/locations/*/sources/*/migratingVms/*}:pauseMigration',
                'body' => '*',
                'placeholders' => [
                    'migrating_vm' => [
                        'getters' => [
                            'getMigratingVm',
                        ],
                    ],
                ],
            ],
            'RemoveGroupMigration' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{group=projects/*/locations/*/groups/*}:removeGroupMigration',
                'body' => '*',
                'placeholders' => [
                    'group' => [
                        'getters' => [
                            'getGroup',
                        ],
                    ],
                ],
            ],
            'ResumeMigration' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{migrating_vm=projects/*/locations/*/sources/*/migratingVms/*}:resumeMigration',
                'body' => '*',
                'placeholders' => [
                    'migrating_vm' => [
                        'getters' => [
                            'getMigratingVm',
                        ],
                    ],
                ],
            ],
            'StartMigration' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{migrating_vm=projects/*/locations/*/sources/*/migratingVms/*}:startMigration',
                'body' => '*',
                'placeholders' => [
                    'migrating_vm' => [
                        'getters' => [
                            'getMigratingVm',
                        ],
                    ],
                ],
            ],
            'UpdateGroup' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{group.name=projects/*/locations/*/groups/*}',
                'body' => 'group',
                'placeholders' => [
                    'group.name' => [
                        'getters' => [
                            'getGroup',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMigratingVm' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{migrating_vm.name=projects/*/locations/*/sources/*/migratingVms/*}',
                'body' => 'migrating_vm',
                'placeholders' => [
                    'migrating_vm.name' => [
                        'getters' => [
                            'getMigratingVm',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSource' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{source.name=projects/*/locations/*/sources/*}',
                'body' => 'source',
                'placeholders' => [
                    'source.name' => [
                        'getters' => [
                            'getSource',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTargetProject' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{target_project.name=projects/*/locations/*/targetProjects/*}',
                'body' => 'target_project',
                'placeholders' => [
                    'target_project.name' => [
                        'getters' => [
                            'getTargetProject',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpgradeAppliance' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{datacenter_connector=projects/*/locations/*/sources/*/datacenterConnectors/*}:upgradeAppliance',
                'body' => '*',
                'placeholders' => [
                    'datacenter_connector' => [
                        'getters' => [
                            'getDatacenterConnector',
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
];
