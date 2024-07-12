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
        'google.cloud.securitycenter.v1.SecurityCenter' => [
            'BatchCreateResourceValueConfigs' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*}/resourceValueConfigs:batchCreate',
                'body' => '*',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/findings:bulkMute',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*}/findings:bulkMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*}/findings:bulkMute',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/bigQueryExports',
                'body' => 'big_query_export',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*}/bigQueryExports',
                        'body' => 'big_query_export',
                        'queryParams' => [
                            'big_query_export_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*}/bigQueryExports',
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
            'CreateEventThreatDetectionCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*/eventThreatDetectionSettings}/customModules',
                'body' => 'event_threat_detection_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/eventThreatDetectionSettings}/customModules',
                        'body' => 'event_threat_detection_custom_module',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/eventThreatDetectionSettings}/customModules',
                        'body' => 'event_threat_detection_custom_module',
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
            'CreateFinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*/sources/*}/findings',
                'body' => 'finding',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/muteConfigs',
                'body' => 'mute_config',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*}/muteConfigs',
                        'body' => 'mute_config',
                        'queryParams' => [
                            'mute_config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*}/muteConfigs',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/notificationConfigs',
                'body' => 'notification_config',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*}/notificationConfigs',
                        'body' => 'notification_config',
                        'queryParams' => [
                            'config_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*}/notificationConfigs',
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
            'CreateSecurityHealthAnalyticsCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*/securityHealthAnalyticsSettings}/customModules',
                'body' => 'security_health_analytics_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/securityHealthAnalyticsSettings}/customModules',
                        'body' => 'security_health_analytics_custom_module',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/securityHealthAnalyticsSettings}/customModules',
                        'body' => 'security_health_analytics_custom_module',
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
            'CreateSource' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*}/sources',
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
                'uriTemplate' => '/v1/{name=organizations/*/bigQueryExports/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/bigQueryExports/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/bigQueryExports/*}',
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
            'DeleteEventThreatDetectionCustomModule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=organizations/*/eventThreatDetectionSettings/customModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/eventThreatDetectionSettings/customModules/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/eventThreatDetectionSettings/customModules/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/muteConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/muteConfigs/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/notificationConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/notificationConfigs/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/notificationConfigs/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/resourceValueConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSecurityHealthAnalyticsCustomModule' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=organizations/*/securityHealthAnalyticsSettings/customModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=folders/*/securityHealthAnalyticsSettings/customModules/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/securityHealthAnalyticsSettings/customModules/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/bigQueryExports/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/bigQueryExports/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/bigQueryExports/*}',
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
            'GetEffectiveEventThreatDetectionCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/eventThreatDetectionSettings/effectiveCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/eventThreatDetectionSettings/effectiveCustomModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/eventThreatDetectionSettings/effectiveCustomModules/*}',
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
            'GetEffectiveSecurityHealthAnalyticsCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/securityHealthAnalyticsSettings/effectiveCustomModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/securityHealthAnalyticsSettings/effectiveCustomModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/securityHealthAnalyticsSettings/effectiveCustomModules/*}',
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
            'GetEventThreatDetectionCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/eventThreatDetectionSettings/customModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/eventThreatDetectionSettings/customModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/eventThreatDetectionSettings/customModules/*}',
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
                'uriTemplate' => '/v1/{resource=organizations/*/sources/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{name=organizations/*/muteConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=organizations/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/locations/*/muteConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/muteConfigs/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/notificationConfigs/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/notificationConfigs/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/notificationConfigs/*}',
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
            'GetOrganizationSettings' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/organizationSettings}',
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
                'uriTemplate' => '/v1/{name=organizations/*/resourceValueConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSecurityHealthAnalyticsCustomModule' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/securityHealthAnalyticsSettings/customModules/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=folders/*/securityHealthAnalyticsSettings/customModules/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/securityHealthAnalyticsSettings/customModules/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/simulations/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/sources/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/simulations/*/valuedResources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GroupAssets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*}/assets:group',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*}/assets:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*}/assets:group',
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
            'GroupFindings' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*/sources/*}/findings:group',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/sources/*}/findings:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/sources/*}/findings:group',
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
            'ListAssets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*}/assets',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/assets',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*}/assets',
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
                'uriTemplate' => '/v1/{parent=organizations/*/simulations/*}/attackPaths',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/simulations/*/valuedResources/*}/attackPaths',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/simulations/*/attackExposureResults/*}/attackPaths',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/bigQueryExports',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/bigQueryExports',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*}/bigQueryExports',
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
            'ListDescendantEventThreatDetectionCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/eventThreatDetectionSettings}/customModules:listDescendant',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/eventThreatDetectionSettings}/customModules:listDescendant',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/eventThreatDetectionSettings}/customModules:listDescendant',
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
            'ListDescendantSecurityHealthAnalyticsCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/securityHealthAnalyticsSettings}/customModules:listDescendant',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/securityHealthAnalyticsSettings}/customModules:listDescendant',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/securityHealthAnalyticsSettings}/customModules:listDescendant',
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
            'ListEffectiveEventThreatDetectionCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/eventThreatDetectionSettings}/effectiveCustomModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/eventThreatDetectionSettings}/effectiveCustomModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/eventThreatDetectionSettings}/effectiveCustomModules',
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
            'ListEffectiveSecurityHealthAnalyticsCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/securityHealthAnalyticsSettings}/effectiveCustomModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/securityHealthAnalyticsSettings}/effectiveCustomModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/securityHealthAnalyticsSettings}/effectiveCustomModules',
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
            'ListEventThreatDetectionCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/eventThreatDetectionSettings}/customModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/eventThreatDetectionSettings}/customModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/eventThreatDetectionSettings}/customModules',
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
                'uriTemplate' => '/v1/{parent=organizations/*/sources/*}/findings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/sources/*}/findings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/sources/*}/findings',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/muteConfigs',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/muteConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*}/muteConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/locations/*/muteConfigs}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/locations/*/muteConfigs}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*/muteConfigs}',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/notificationConfigs',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/notificationConfigs',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*}/notificationConfigs',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/resourceValueConfigs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSecurityHealthAnalyticsCustomModules' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/securityHealthAnalyticsSettings}/customModules',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*/securityHealthAnalyticsSettings}/customModules',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/securityHealthAnalyticsSettings}/customModules',
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
                'uriTemplate' => '/v1/{parent=organizations/*}/sources',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=folders/*}/sources',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*}/sources',
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
                'uriTemplate' => '/v1/{parent=organizations/*/simulations/*}/valuedResources',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*/simulations/*/attackExposureResults/*}/valuedResources',
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
            'RunAssetDiscovery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*}/assets:runDiscovery',
                'body' => '*',
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
                'uriTemplate' => '/v1/{name=organizations/*/sources/*/findings/*}:setState',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/sources/*/findings/*}:setState',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/sources/*/findings/*}:setState',
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
                'uriTemplate' => '/v1/{resource=organizations/*/sources/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{name=organizations/*/sources/*/findings/*}:setMute',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=folders/*/sources/*/findings/*}:setMute',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/sources/*/findings/*}:setMute',
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
            'SimulateSecurityHealthAnalyticsCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*/securityHealthAnalyticsSettings}/customModules:simulate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/securityHealthAnalyticsSettings}/customModules:simulate',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/securityHealthAnalyticsSettings}/customModules:simulate',
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
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=organizations/*/sources/*}:testIamPermissions',
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
                'uriTemplate' => '/v1/{big_query_export.name=organizations/*/bigQueryExports/*}',
                'body' => 'big_query_export',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{big_query_export.name=folders/*/bigQueryExports/*}',
                        'body' => 'big_query_export',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{big_query_export.name=projects/*/bigQueryExports/*}',
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
            'UpdateEventThreatDetectionCustomModule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{event_threat_detection_custom_module.name=organizations/*/eventThreatDetectionSettings/customModules/*}',
                'body' => 'event_threat_detection_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{event_threat_detection_custom_module.name=folders/*/eventThreatDetectionSettings/customModules/*}',
                        'body' => 'event_threat_detection_custom_module',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{event_threat_detection_custom_module.name=projects/*/eventThreatDetectionSettings/customModules/*}',
                        'body' => 'event_threat_detection_custom_module',
                    ],
                ],
                'placeholders' => [
                    'event_threat_detection_custom_module.name' => [
                        'getters' => [
                            'getEventThreatDetectionCustomModule',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateExternalSystem' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{external_system.name=organizations/*/sources/*/findings/*/externalSystems/*}',
                'body' => 'external_system',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{external_system.name=folders/*/sources/*/findings/*/externalSystems/*}',
                        'body' => 'external_system',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{external_system.name=projects/*/sources/*/findings/*/externalSystems/*}',
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
                'uriTemplate' => '/v1/{finding.name=organizations/*/sources/*/findings/*}',
                'body' => 'finding',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{finding.name=folders/*/sources/*/findings/*}',
                        'body' => 'finding',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{finding.name=projects/*/sources/*/findings/*}',
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
                'uriTemplate' => '/v1/{mute_config.name=organizations/*/muteConfigs/*}',
                'body' => 'mute_config',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{mute_config.name=folders/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{mute_config.name=projects/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{mute_config.name=organizations/*/locations/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{mute_config.name=folders/*/locations/*/muteConfigs/*}',
                        'body' => 'mute_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{mute_config.name=projects/*/locations/*/muteConfigs/*}',
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
                'uriTemplate' => '/v1/{notification_config.name=organizations/*/notificationConfigs/*}',
                'body' => 'notification_config',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{notification_config.name=folders/*/notificationConfigs/*}',
                        'body' => 'notification_config',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{notification_config.name=projects/*/notificationConfigs/*}',
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
            'UpdateOrganizationSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{organization_settings.name=organizations/*/organizationSettings}',
                'body' => 'organization_settings',
                'placeholders' => [
                    'organization_settings.name' => [
                        'getters' => [
                            'getOrganizationSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateResourceValueConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{resource_value_config.name=organizations/*/resourceValueConfigs/*}',
                'body' => 'resource_value_config',
                'placeholders' => [
                    'resource_value_config.name' => [
                        'getters' => [
                            'getResourceValueConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSecurityHealthAnalyticsCustomModule' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{security_health_analytics_custom_module.name=organizations/*/securityHealthAnalyticsSettings/customModules/*}',
                'body' => 'security_health_analytics_custom_module',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_health_analytics_custom_module.name=folders/*/securityHealthAnalyticsSettings/customModules/*}',
                        'body' => 'security_health_analytics_custom_module',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_health_analytics_custom_module.name=projects/*/securityHealthAnalyticsSettings/customModules/*}',
                        'body' => 'security_health_analytics_custom_module',
                    ],
                ],
                'placeholders' => [
                    'security_health_analytics_custom_module.name' => [
                        'getters' => [
                            'getSecurityHealthAnalyticsCustomModule',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSecurityMarks' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{security_marks.name=organizations/*/assets/*/securityMarks}',
                'body' => 'security_marks',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_marks.name=folders/*/assets/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_marks.name=projects/*/assets/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_marks.name=organizations/*/sources/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_marks.name=folders/*/sources/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{security_marks.name=projects/*/sources/*/findings/*/securityMarks}',
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
                'uriTemplate' => '/v1/{source.name=organizations/*/sources/*}',
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
            'ValidateEventThreatDetectionCustomModule' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=organizations/*/eventThreatDetectionSettings}:validateCustomModule',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=folders/*/eventThreatDetectionSettings}:validateCustomModule',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/eventThreatDetectionSettings}:validateCustomModule',
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
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=organizations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=organizations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=organizations/*/operations}',
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
