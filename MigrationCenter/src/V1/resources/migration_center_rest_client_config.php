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
        'google.cloud.migrationcenter.v1.MigrationCenter' => [
            'AddAssetsToGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{group=projects/*/locations/*/groups/*}:addAssets',
                'body' => '*',
                'placeholders' => [
                    'group' => [
                        'getters' => [
                            'getGroup',
                        ],
                    ],
                ],
            ],
            'AggregateAssetsValues' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets:aggregateValues',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
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
            'CreateImportDataFile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/importJobs/*}/importDataFiles',
                'body' => 'import_data_file',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'import_data_file_id',
                ],
            ],
            'CreateImportJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/importJobs',
                'body' => 'import_job',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'import_job_id',
                ],
            ],
            'CreatePreferenceSet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/preferenceSets',
                'body' => 'preference_set',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'preference_set_id',
                ],
            ],
            'CreateReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/reportConfigs/*}/reports',
                'body' => 'report',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'report_id',
                ],
            ],
            'CreateReportConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/reportConfigs',
                'body' => 'report_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'report_config_id',
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
            'DeleteAsset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/assets/*}',
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
            'DeleteImportDataFile' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/importJobs/*/importDataFiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteImportJob' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/importJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePreferenceSet' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/preferenceSets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteReport' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reportConfigs/*/reports/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteReportConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reportConfigs/*}',
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
            'GetAsset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/assets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetErrorFrame' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sources/*/errorFrames/*}',
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
            'GetImportDataFile' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/importJobs/*/importDataFiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetImportJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/importJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPreferenceSet' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/preferenceSets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetReport' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reportConfigs/*/reports/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetReportConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/reportConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/settings}',
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
            'ListAssets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListErrorFrames' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/sources/*}/errorFrames',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
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
            ],
            'ListImportDataFiles' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/importJobs/*}/importDataFiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListImportJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/importJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPreferenceSets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/preferenceSets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReportConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/reportConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReports' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/reportConfigs/*}/reports',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
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
            ],
            'RemoveAssetsFromGroup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{group=projects/*/locations/*/groups/*}:removeAssets',
                'body' => '*',
                'placeholders' => [
                    'group' => [
                        'getters' => [
                            'getGroup',
                        ],
                    ],
                ],
            ],
            'ReportAssetFrames' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/assets:reportAssetFrames',
                'body' => 'frames',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RunImportJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/importJobs/*}:run',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAsset' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{asset.name=projects/*/locations/*/assets/*}',
                'body' => 'asset',
                'placeholders' => [
                    'asset.name' => [
                        'getters' => [
                            'getAsset',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateImportJob' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{import_job.name=projects/*/locations/*/importJobs/*}',
                'body' => 'import_job',
                'placeholders' => [
                    'import_job.name' => [
                        'getters' => [
                            'getImportJob',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdatePreferenceSet' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{preference_set.name=projects/*/locations/*/preferenceSets/*}',
                'body' => 'preference_set',
                'placeholders' => [
                    'preference_set.name' => [
                        'getters' => [
                            'getPreferenceSet',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{settings.name=projects/*/locations/*/settings}',
                'body' => 'settings',
                'placeholders' => [
                    'settings.name' => [
                        'getters' => [
                            'getSettings',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
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
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'ValidateImportJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/importJobs/*}:validate',
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
