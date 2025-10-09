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
            'BulkMuteFindings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\SecurityCenter\V1\BulkMuteFindingsResponse',
                    'metadataReturnType' => '\Google\Protobuf\GPBEmpty',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RunAssetDiscovery' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\SecurityCenter\V1\RunAssetDiscoveryResponse',
                    'metadataReturnType' => '\Google\Protobuf\GPBEmpty',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateResourceValueConfigs' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\BatchCreateResourceValueConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateBigQueryExport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\BigQueryExport',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateEventThreatDetectionCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\EventThreatDetectionCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateFinding' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Finding',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateMuteConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\MuteConfig',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateNotificationConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\NotificationConfig',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSecurityHealthAnalyticsCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\SecurityHealthAnalyticsCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateSource' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Source',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteBigQueryExport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEventThreatDetectionCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteMuteConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteNotificationConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteResourceValueConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSecurityHealthAnalyticsCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBigQueryExport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\BigQueryExport',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEffectiveEventThreatDetectionCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\EffectiveEventThreatDetectionCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEffectiveSecurityHealthAnalyticsCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\EffectiveSecurityHealthAnalyticsCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEventThreatDetectionCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\EventThreatDetectionCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetMuteConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\MuteConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNotificationConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\NotificationConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOrganizationSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\OrganizationSettings',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetResourceValueConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ResourceValueConfig',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSecurityHealthAnalyticsCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\SecurityHealthAnalyticsCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSimulation' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Simulation',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSource' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Source',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetValuedResource' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ValuedResource',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GroupAssets' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGroupByResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\GroupAssetsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GroupFindings' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGroupByResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\GroupFindingsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAssets' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getListAssetsResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListAssetsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAttackPaths' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAttackPaths',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListAttackPathsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListBigQueryExports' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getBigQueryExports',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListBigQueryExportsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDescendantEventThreatDetectionCustomModules' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEventThreatDetectionCustomModules',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListDescendantEventThreatDetectionCustomModulesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDescendantSecurityHealthAnalyticsCustomModules' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSecurityHealthAnalyticsCustomModules',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListDescendantSecurityHealthAnalyticsCustomModulesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEffectiveEventThreatDetectionCustomModules' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEffectiveEventThreatDetectionCustomModules',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListEffectiveEventThreatDetectionCustomModulesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEffectiveSecurityHealthAnalyticsCustomModules' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEffectiveSecurityHealthAnalyticsCustomModules',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListEffectiveSecurityHealthAnalyticsCustomModulesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListEventThreatDetectionCustomModules' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEventThreatDetectionCustomModules',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListEventThreatDetectionCustomModulesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFindings' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getListFindingsResults',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListFindingsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMuteConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMuteConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListMuteConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNotificationConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getNotificationConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListNotificationConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListResourceValueConfigs' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResourceValueConfigs',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListResourceValueConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSecurityHealthAnalyticsCustomModules' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSecurityHealthAnalyticsCustomModules',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListSecurityHealthAnalyticsCustomModulesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListSources' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSources',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListSourcesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListValuedResources' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getValuedResources',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ListValuedResourcesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetFindingState' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Finding',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'SetMute' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Finding',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SimulateSecurityHealthAnalyticsCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\SimulateSecurityHealthAnalyticsCustomModuleResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateBigQueryExport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\BigQueryExport',
                'headerParams' => [
                    [
                        'keyName' => 'big_query_export.name',
                        'fieldAccessors' => [
                            'getBigQueryExport',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateEventThreatDetectionCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\EventThreatDetectionCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'event_threat_detection_custom_module.name',
                        'fieldAccessors' => [
                            'getEventThreatDetectionCustomModule',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateExternalSystem' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ExternalSystem',
                'headerParams' => [
                    [
                        'keyName' => 'external_system.name',
                        'fieldAccessors' => [
                            'getExternalSystem',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateFinding' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Finding',
                'headerParams' => [
                    [
                        'keyName' => 'finding.name',
                        'fieldAccessors' => [
                            'getFinding',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateMuteConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\MuteConfig',
                'headerParams' => [
                    [
                        'keyName' => 'mute_config.name',
                        'fieldAccessors' => [
                            'getMuteConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNotificationConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\NotificationConfig',
                'headerParams' => [
                    [
                        'keyName' => 'notification_config.name',
                        'fieldAccessors' => [
                            'getNotificationConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateOrganizationSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\OrganizationSettings',
                'headerParams' => [
                    [
                        'keyName' => 'organization_settings.name',
                        'fieldAccessors' => [
                            'getOrganizationSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateResourceValueConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ResourceValueConfig',
                'headerParams' => [
                    [
                        'keyName' => 'resource_value_config.name',
                        'fieldAccessors' => [
                            'getResourceValueConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSecurityHealthAnalyticsCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\SecurityHealthAnalyticsCustomModule',
                'headerParams' => [
                    [
                        'keyName' => 'security_health_analytics_custom_module.name',
                        'fieldAccessors' => [
                            'getSecurityHealthAnalyticsCustomModule',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSecurityMarks' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\SecurityMarks',
                'headerParams' => [
                    [
                        'keyName' => 'security_marks.name',
                        'fieldAccessors' => [
                            'getSecurityMarks',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSource' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\Source',
                'headerParams' => [
                    [
                        'keyName' => 'source.name',
                        'fieldAccessors' => [
                            'getSource',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ValidateEventThreatDetectionCustomModule' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V1\ValidateEventThreatDetectionCustomModuleResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'bigQueryExport' => 'organizations/{organization}/bigQueryExports/{export}',
                'dlpJob' => 'projects/{project}/dlpJobs/{dlp_job}',
                'effectiveEventThreatDetectionCustomModule' => 'organizations/{organization}/eventThreatDetectionSettings/effectiveCustomModules/{module}',
                'effectiveSecurityHealthAnalyticsCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'eventThreatDetectionCustomModule' => 'organizations/{organization}/eventThreatDetectionSettings/customModules/{module}',
                'eventThreatDetectionSettings' => 'organizations/{organization}/eventThreatDetectionSettings',
                'externalSystem' => 'organizations/{organization}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'finding' => 'organizations/{organization}/sources/{source}/findings/{finding}',
                'folder' => 'folders/{folder}',
                'folderAssetSecurityMarks' => 'folders/{folder}/assets/{asset}/securityMarks',
                'folderConstraintName' => 'folders/{folder}/policies/{constraint_name}',
                'folderCustomModule' => 'folders/{folder}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'folderEffectiveCustomModule' => 'folders/{folder}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'folderEventThreatDetectionSettings' => 'folders/{folder}/eventThreatDetectionSettings',
                'folderExport' => 'folders/{folder}/bigQueryExports/{export}',
                'folderLocation' => 'folders/{folder}/locations/{location}',
                'folderLocationMuteConfig' => 'folders/{folder}/locations/{location}/muteConfigs/{mute_config}',
                'folderModule' => 'folders/{folder}/eventThreatDetectionSettings/customModules/{module}',
                'folderMuteConfig' => 'folders/{folder}/muteConfigs/{mute_config}',
                'folderNotificationConfig' => 'folders/{folder}/notificationConfigs/{notification_config}',
                'folderSecurityHealthAnalyticsSettings' => 'folders/{folder}/securityHealthAnalyticsSettings',
                'folderSource' => 'folders/{folder}/sources/{source}',
                'folderSourceFinding' => 'folders/{folder}/sources/{source}/findings/{finding}',
                'folderSourceFindingExternalsystem' => 'folders/{folder}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'folderSourceFindingSecurityMarks' => 'folders/{folder}/sources/{source}/findings/{finding}/securityMarks',
                'location' => 'projects/{project}/locations/{location}',
                'muteConfig' => 'organizations/{organization}/muteConfigs/{mute_config}',
                'notificationConfig' => 'organizations/{organization}/notificationConfigs/{notification_config}',
                'organization' => 'organizations/{organization}',
                'organizationAssetSecurityMarks' => 'organizations/{organization}/assets/{asset}/securityMarks',
                'organizationConstraintName' => 'organizations/{organization}/policies/{constraint_name}',
                'organizationCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'organizationEffectiveCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'organizationEventThreatDetectionSettings' => 'organizations/{organization}/eventThreatDetectionSettings',
                'organizationExport' => 'organizations/{organization}/bigQueryExports/{export}',
                'organizationLocation' => 'organizations/{organization}/locations/{location}',
                'organizationLocationMuteConfig' => 'organizations/{organization}/locations/{location}/muteConfigs/{mute_config}',
                'organizationModule' => 'organizations/{organization}/eventThreatDetectionSettings/customModules/{module}',
                'organizationMuteConfig' => 'organizations/{organization}/muteConfigs/{mute_config}',
                'organizationNotificationConfig' => 'organizations/{organization}/notificationConfigs/{notification_config}',
                'organizationSecurityHealthAnalyticsSettings' => 'organizations/{organization}/securityHealthAnalyticsSettings',
                'organizationSettings' => 'organizations/{organization}/organizationSettings',
                'organizationSource' => 'organizations/{organization}/sources/{source}',
                'organizationSourceFinding' => 'organizations/{organization}/sources/{source}/findings/{finding}',
                'organizationSourceFindingExternalsystem' => 'organizations/{organization}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'organizationSourceFindingSecurityMarks' => 'organizations/{organization}/sources/{source}/findings/{finding}/securityMarks',
                'policy' => 'organizations/{organization}/policies/{constraint_name}',
                'project' => 'projects/{project}',
                'projectAssetSecurityMarks' => 'projects/{project}/assets/{asset}/securityMarks',
                'projectConstraintName' => 'projects/{project}/policies/{constraint_name}',
                'projectCustomModule' => 'projects/{project}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'projectDlpJob' => 'projects/{project}/dlpJobs/{dlp_job}',
                'projectEffectiveCustomModule' => 'projects/{project}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'projectEventThreatDetectionSettings' => 'projects/{project}/eventThreatDetectionSettings',
                'projectExport' => 'projects/{project}/bigQueryExports/{export}',
                'projectLocationDlpJob' => 'projects/{project}/locations/{location}/dlpJobs/{dlp_job}',
                'projectLocationMuteConfig' => 'projects/{project}/locations/{location}/muteConfigs/{mute_config}',
                'projectLocationTableProfile' => 'projects/{project}/locations/{location}/tableProfiles/{table_profile}',
                'projectModule' => 'projects/{project}/eventThreatDetectionSettings/customModules/{module}',
                'projectMuteConfig' => 'projects/{project}/muteConfigs/{mute_config}',
                'projectNotificationConfig' => 'projects/{project}/notificationConfigs/{notification_config}',
                'projectSecurityHealthAnalyticsSettings' => 'projects/{project}/securityHealthAnalyticsSettings',
                'projectSource' => 'projects/{project}/sources/{source}',
                'projectSourceFinding' => 'projects/{project}/sources/{source}/findings/{finding}',
                'projectSourceFindingExternalsystem' => 'projects/{project}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'projectSourceFindingSecurityMarks' => 'projects/{project}/sources/{source}/findings/{finding}/securityMarks',
                'projectTableProfile' => 'projects/{project}/tableProfiles/{table_profile}',
                'resourceValueConfig' => 'organizations/{organization}/resourceValueConfigs/{resource_value_config}',
                'securityHealthAnalyticsCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'securityHealthAnalyticsSettings' => 'organizations/{organization}/securityHealthAnalyticsSettings',
                'securityMarks' => 'organizations/{organization}/assets/{asset}/securityMarks',
                'simulation' => 'organizations/{organization}/simulations/{simulation}',
                'source' => 'organizations/{organization}/sources/{source}',
                'tableDataProfile' => 'projects/{project}/tableProfiles/{table_profile}',
                'topic' => 'projects/{project}/topics/{topic}',
                'valuedResource' => 'organizations/{organization}/simulations/{simulation}/valuedResources/{valued_resource}',
            ],
        ],
    ],
];
