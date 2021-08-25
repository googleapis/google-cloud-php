<?php

return [
    'interfaces' => [
        'google.cloud.clouddms.v1.DataMigrationService' => [
            'CreateConnectionProfile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connectionProfiles',
                'body' => 'connection_profile',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'connection_profile_id',
                ],
            ],
            'CreateMigrationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/migrationJobs',
                'body' => 'migration_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'migration_job_id',
                ],
            ],
            'DeleteConnectionProfile' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connectionProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMigrationJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateSshScript' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{migration_job=projects/*/locations/*/migrationJobs/*}:generateSshScript',
                'body' => '*',
                'placeholders' => [
                    'migration_job' => [
                        'getters' => [
                            'getMigrationJob',
                        ],
                    ],
                ],
            ],
            'GetConnectionProfile' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connectionProfiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMigrationJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListConnectionProfiles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connectionProfiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMigrationJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/migrationJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PromoteMigrationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}:promote',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RestartMigrationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}:restart',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumeMigrationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StartMigrationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}:start',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'StopMigrationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}:stop',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateConnectionProfile' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{connection_profile.name=projects/*/locations/*/connectionProfiles/*}',
                'body' => 'connection_profile',
                'placeholders' => [
                    'connection_profile.name' => [
                        'getters' => [
                            'getConnectionProfile',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateMigrationJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{migration_job.name=projects/*/locations/*/migrationJobs/*}',
                'body' => 'migration_job',
                'placeholders' => [
                    'migration_job.name' => [
                        'getters' => [
                            'getMigrationJob',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'VerifyMigrationJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/migrationJobs/*}:verify',
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
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/connectionProfiles/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/migrationJobs/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/connectionProfiles/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/migrationJobs/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/migrationJobs/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/connectionProfiles/*}:testIamPermissions',
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
];
