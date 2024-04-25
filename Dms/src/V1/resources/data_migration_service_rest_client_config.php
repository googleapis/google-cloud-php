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
        'google.cloud.clouddms.v1.DataMigrationService' => [
            'ApplyConversionWorkspace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*}:apply',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CommitConversionWorkspace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*}:commit',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ConvertConversionWorkspace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*}:convert',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
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
            'CreateConversionWorkspace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversionWorkspaces',
                'body' => 'conversion_workspace',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'conversion_workspace_id',
                ],
            ],
            'CreateMappingRule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/conversionWorkspaces/*}/mappingRules',
                'body' => 'mapping_rule',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'mapping_rule_id',
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
            'CreatePrivateConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateConnections',
                'body' => 'private_connection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'private_connection_id',
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
            'DeleteConversionWorkspace' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMappingRule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*/mappingRules/*}',
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
            'DeletePrivateConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DescribeConversionWorkspaceRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{conversion_workspace=projects/*/locations/*/conversionWorkspaces/*}:describeConversionWorkspaceRevisions',
                'placeholders' => [
                    'conversion_workspace' => [
                        'getters' => [
                            'getConversionWorkspace',
                        ],
                    ],
                ],
            ],
            'DescribeDatabaseEntities' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{conversion_workspace=projects/*/locations/*/conversionWorkspaces/*}:describeDatabaseEntities',
                'placeholders' => [
                    'conversion_workspace' => [
                        'getters' => [
                            'getConversionWorkspace',
                        ],
                    ],
                ],
            ],
            'FetchStaticIps' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}:fetchStaticIps',
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
            'GenerateTcpProxyScript' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{migration_job=projects/*/locations/*/migrationJobs/*}:generateTcpProxyScript',
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
            'GetConversionWorkspace' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMappingRule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*/mappingRules/*}',
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
            'GetPrivateConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/privateConnections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportMappingRules' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/conversionWorkspaces/*}/mappingRules:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
            'ListConversionWorkspaces' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/conversionWorkspaces',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMappingRules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/conversionWorkspaces/*}/mappingRules',
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
            'ListPrivateConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/privateConnections',
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
            'RollbackConversionWorkspace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchBackgroundJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{conversion_workspace=projects/*/locations/*/conversionWorkspaces/*}:searchBackgroundJobs',
                'placeholders' => [
                    'conversion_workspace' => [
                        'getters' => [
                            'getConversionWorkspace',
                        ],
                    ],
                ],
            ],
            'SeedConversionWorkspace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/conversionWorkspaces/*}:seed',
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
            'UpdateConversionWorkspace' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{conversion_workspace.name=projects/*/locations/*/conversionWorkspaces/*}',
                'body' => 'conversion_workspace',
                'placeholders' => [
                    'conversion_workspace.name' => [
                        'getters' => [
                            'getConversionWorkspace',
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
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/conversionWorkspaces/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateConnections/*}:getIamPolicy',
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
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/conversionWorkspaces/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateConnections/*}:setIamPolicy',
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
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/conversionWorkspaces/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/privateConnections/*}:testIamPermissions',
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
