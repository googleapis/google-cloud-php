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
        'google.cloud.securitycenter.v2.SecurityCenter' => [
            'BatchCreateResourceValueConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/resourceValueConfigs:batchCreate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/resourceValueConfigs:batchCreate',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BulkMuteFindings' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/findings:bulkMute',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/findings:bulkMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*}/findings:bulkMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/findings:bulkMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/findings:bulkMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/findings:bulkMute',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateBigQueryExport' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/bigQueryExports',
                'body' => 'big_query_export',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/bigQueryExports',
                        'body' => 'big_query_export',
                        'queryParams' => [
                            'big_query_export_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/bigQueryExports',
                        'body' => 'big_query_export',
                        'queryParams' => [
                            'big_query_export_id',
                        ],
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'big_query_export_id',
                ],
            ],
            'CreateFinding' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*/sources/*/locations/*}/findings',
                'body' => 'finding',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*/sources/*}/findings',
                        'body' => 'finding',
                        'queryParams' => [
                            'finding_id',
                        ],
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'finding_id',
                ],
            ],
            'CreateMuteConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/muteConfigs',
                'body' => 'mute_config',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'mute_config_id',
                ],
            ],
            'CreateNotificationConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/notificationConfigs',
                'body' => 'notification_config',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/notificationConfigs',
                        'body' => 'notification_config',
                        'queryParams' => [
                            'config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/notificationConfigs',
                        'body' => 'notification_config',
                        'queryParams' => [
                            'config_id',
                        ],
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'config_id',
                ],
            ],
            'CreateSource' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/sources',
                'body' => 'source',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteBigQueryExport' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/locations/*/bigQueryExports/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/bigQueryExports/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/bigQueryExports/*}',
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
            'DeleteMuteConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/muteConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=folders/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/muteConfigs/*}',
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
            'DeleteNotificationConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/locations/*/notificationConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/notificationConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/notificationConfigs/*}',
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
            'DeleteResourceValueConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/resourceValueConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/resourceValueConfigs/*}',
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
            'GetBigQueryExport' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/locations/*/bigQueryExports/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/bigQueryExports/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/bigQueryExports/*}',
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
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=organizations/*/sources/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetMuteConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/muteConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/muteConfigs/*}',
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
            'GetNotificationConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/locations/*/notificationConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/locations/*/notificationConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/notificationConfigs/*}',
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
            'GetResourceValueConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/resourceValueConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/resourceValueConfigs/*}',
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
            'GetSimulation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/simulations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/simulations/*}',
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
            'GetSource' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/sources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetValuedResource' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/simulations/*/valuedResources/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/locations/*/simulations/*/valuedResources/*}',
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
            'GroupFindings' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*/sources/*}/findings:group',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*/sources/*/locations/*}/findings:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*/sources/*}/findings:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*/sources/*/locations/*}/findings:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/sources/*}/findings:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/sources/*/locations/*}/findings:group',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAttackPaths' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*/simulations/*}/attackPaths',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/attackPaths',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/simulations/*/valuedResources/*}/attackPaths',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/locations/*/simulations/*/valuedResources/*}/attackPaths',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/simulations/*/attackExposureResults/*}/attackPaths',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/locations/*/simulations/*/attackExposureResults/*}/attackPaths',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListBigQueryExports' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/bigQueryExports',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/bigQueryExports',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/bigQueryExports',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFindings' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*/sources/*}/findings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/sources/*/locations/*}/findings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*/sources/*}/findings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*/sources/*/locations/*}/findings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/sources/*}/findings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/sources/*/locations/*}/findings',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMuteConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*}/muteConfigs',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/muteConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*}/muteConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/muteConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/muteConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/muteConfigs',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNotificationConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/notificationConfigs',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*/locations/*}/notificationConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*}/notificationConfigs',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListResourceValueConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*}/resourceValueConfigs',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/locations/*}/resourceValueConfigs',
                    ],
                ],
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
                'uriTemplate' => '/v2/{parent=organizations/*}/sources',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*}/sources',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*}/sources',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListValuedResources' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*/simulations/*}/valuedResources',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*/simulations/*/attackExposureResults/*}/valuedResources',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/valuedResources',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetFindingState' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=organizations/*/sources/*/findings/*}:setState',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=organizations/*/sources/*/locations/*/findings/*}:setState',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=folders/*/sources/*/findings/*}:setState',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=folders/*/sources/*/locations/*/findings/*}:setState',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/sources/*/findings/*}:setState',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/sources/*/locations/*/findings/*}:setState',
                        'body' => '*',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=organizations/*/sources/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetMute' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=organizations/*/sources/*/findings/*}:setMute',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=organizations/*/sources/*/locations/*/findings/*}:setMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=folders/*/sources/*/findings/*}:setMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=folders/*/sources/*/locations/*/findings/*}:setMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/sources/*/findings/*}:setMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/sources/*/locations/*/findings/*}:setMute',
                        'body' => '*',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=organizations/*/sources/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateBigQueryExport' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{big_query_export.name=organizations/*/locations/*/bigQueryExports/*}',
                'body' => 'big_query_export',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{big_query_export.name=folders/*/locations/*/bigQueryExports/*}',
                        'body' => 'big_query_export',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{big_query_export.name=projects/*/locations/*/bigQueryExports/*}',
                        'body' => 'big_query_export',
                    ],
                ],
                'placeholders' => [
                    'big_query_export.name' => [
                        'getters' => [
                            'getBigQueryExport',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateExternalSystem' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{external_system.name=organizations/*/sources/*/findings/*/externalSystems/*}',
                'body' => 'external_system',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{external_system.name=organizations/*/sources/*/locations/*/findings/*/externalSystems/*}',
                        'body' => 'external_system',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{external_system.name=folders/*/sources/*/findings/*/externalSystems/*}',
                        'body' => 'external_system',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{external_system.name=folders/*/sources/*/locations/*/findings/*/externalSystems/*}',
                        'body' => 'external_system',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{external_system.name=projects/*/sources/*/findings/*/externalSystems/*}',
                        'body' => 'external_system',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{external_system.name=projects/*/sources/*/locations/*/findings/*/externalSystems/*}',
                        'body' => 'external_system',
                    ],
                ],
                'placeholders' => [
                    'external_system.name' => [
                        'getters' => [
                            'getExternalSystem',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{finding.name=organizations/*/sources/*/findings/*}',
                'body' => 'finding',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{finding.name=organizations/*/sources/*/locations/*/findings/*}',
                        'body' => 'finding',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{finding.name=folders/*/sources/*/findings/*}',
                        'body' => 'finding',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{finding.name=folders/*/sources/*/locations/*/findings/*}',
                        'body' => 'finding',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{finding.name=projects/*/sources/*/findings/*}',
                        'body' => 'finding',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{finding.name=projects/*/sources/*/locations/*/findings/*}',
                        'body' => 'finding',
                    ],
                ],
                'placeholders' => [
                    'finding.name' => [
                        'getters' => [
                            'getFinding',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMuteConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{mute_config.name=organizations/*/muteConfigs/*}',
                'body' => 'mute_config',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{mute_config.name=organizations/*/locations/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{mute_config.name=folders/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{mute_config.name=folders/*/locations/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{mute_config.name=projects/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{mute_config.name=projects/*/locations/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                ],
                'placeholders' => [
                    'mute_config.name' => [
                        'getters' => [
                            'getMuteConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNotificationConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{notification_config.name=organizations/*/locations/*/notificationConfigs/*}',
                'body' => 'notification_config',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{notification_config.name=folders/*/locations/*/notificationConfigs/*}',
                        'body' => 'notification_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{notification_config.name=projects/*/locations/*/notificationConfigs/*}',
                        'body' => 'notification_config',
                    ],
                ],
                'placeholders' => [
                    'notification_config.name' => [
                        'getters' => [
                            'getNotificationConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateResourceValueConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{resource_value_config.name=organizations/*/resourceValueConfigs/*}',
                'body' => 'resource_value_config',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{resource_value_config.name=organizations/*/locations/*/resourceValueConfigs/*}',
                        'body' => 'resource_value_config',
                    ],
                ],
                'placeholders' => [
                    'resource_value_config.name' => [
                        'getters' => [
                            'getResourceValueConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSecurityMarks' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{security_marks.name=organizations/*/sources/*/findings/*/securityMarks}',
                'body' => 'security_marks',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=organizations/*/assets/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=organizations/*/sources/*/locations/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=folders/*/sources/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=folders/*/assets/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=folders/*/sources/*/locations/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=projects/*/sources/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=projects/*/assets/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{security_marks.name=projects/*/sources/*/locations/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                ],
                'placeholders' => [
                    'security_marks.name' => [
                        'getters' => [
                            'getSecurityMarks',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSource' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{source.name=organizations/*/sources/*}',
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
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=organizations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v2/{name=organizations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=organizations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=organizations/*/operations}',
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
