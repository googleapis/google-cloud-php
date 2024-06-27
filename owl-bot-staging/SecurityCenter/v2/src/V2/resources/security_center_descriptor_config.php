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
            'BulkMuteFindings' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\SecurityCenter\V2\BulkMuteFindingsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\BatchCreateResourceValueConfigsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\BigQueryExport',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Finding',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\MuteConfig',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'CreateNotificationConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V2\NotificationConfig',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Source',
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
            'DeleteMuteConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
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
            'GetBigQueryExport' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V2\BigQueryExport',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\MuteConfig',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'GetNotificationConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V2\NotificationConfig',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ResourceValueConfig',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Simulation',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Source',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ValuedResource',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\GroupFindingsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListAttackPathsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListBigQueryExportsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListFindingsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListMuteConfigsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                        'matchers' => [],
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListNotificationConfigsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListResourceValueConfigsResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListSourcesResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ListValuedResourcesResponse',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Finding',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Finding',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\BigQueryExport',
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
            'UpdateExternalSystem' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ExternalSystem',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Finding',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\MuteConfig',
                'headerParams' => [
                    [
                        'keyName' => 'location',
                        'fieldAccessors' => [
                            'getMuteConfig',
                            'getName',
                        ],
                        'matchers' => [],
                    ],
                ],
            ],
            'UpdateNotificationConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V2\NotificationConfig',
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
            'UpdateResourceValueConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V2\ResourceValueConfig',
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
            'UpdateSecurityMarks' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\SecurityCenter\V2\SecurityMarks',
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
                'responseType' => 'Google\Cloud\SecurityCenter\V2\Source',
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
            'templateMap' => [
                'bigQueryExport' => 'organizations/{organization}/locations/{location}/bigQueryExports/{export}',
                'dlpJob' => 'projects/{project}/dlpJobs/{dlp_job}',
                'externalSystem' => 'organizations/{organization}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'finding' => 'organizations/{organization}/sources/{source}/findings/{finding}',
                'folder' => 'folders/{folder}',
                'folderAssetSecurityMarks' => 'folders/{folder}/assets/{asset}/securityMarks',
                'folderConstraintName' => 'folders/{folder}/policies/{constraint_name}',
                'folderLocation' => 'folders/{folder}/locations/{location}',
                'folderLocationExport' => 'folders/{folder}/locations/{location}/bigQueryExports/{export}',
                'folderLocationMuteConfig' => 'folders/{folder}/locations/{location}/muteConfigs/{mute_config}',
                'folderLocationNotificationConfig' => 'folders/{folder}/locations/{location}/notificationConfigs/{notification_config}',
                'folderMuteConfig' => 'folders/{folder}/muteConfigs/{mute_config}',
                'folderSource' => 'folders/{folder}/sources/{source}',
                'folderSourceFinding' => 'folders/{folder}/sources/{source}/findings/{finding}',
                'folderSourceFindingExternalsystem' => 'folders/{folder}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'folderSourceFindingSecurityMarks' => 'folders/{folder}/sources/{source}/findings/{finding}/securityMarks',
                'folderSourceLocationFinding' => 'folders/{folder}/sources/{source}/locations/{location}/findings/{finding}',
                'folderSourceLocationFindingExternalsystem' => 'folders/{folder}/sources/{source}/locations/{location}/findings/{finding}/externalSystems/{externalsystem}',
                'folderSourceLocationFindingSecurityMarks' => 'folders/{folder}/sources/{source}/locations/{location}/findings/{finding}/securityMarks',
                'location' => 'projects/{project}/locations/{location}',
                'muteConfig' => 'organizations/{organization}/muteConfigs/{mute_config}',
                'notificationConfig' => 'organizations/{organization}/locations/{location}/notificationConfigs/{notification_config}',
                'organization' => 'organizations/{organization}',
                'organizationAssetSecurityMarks' => 'organizations/{organization}/assets/{asset}/securityMarks',
                'organizationConstraintName' => 'organizations/{organization}/policies/{constraint_name}',
                'organizationLocation' => 'organizations/{organization}/locations/{location}',
                'organizationLocationExport' => 'organizations/{organization}/locations/{location}/bigQueryExports/{export}',
                'organizationLocationMuteConfig' => 'organizations/{organization}/locations/{location}/muteConfigs/{mute_config}',
                'organizationLocationNotificationConfig' => 'organizations/{organization}/locations/{location}/notificationConfigs/{notification_config}',
                'organizationLocationResourceValueConfig' => 'organizations/{organization}/locations/{location}/resourceValueConfigs/{resource_value_config}',
                'organizationLocationSimluation' => 'organizations/{organization}/locations/{location}/simulations/{simluation}',
                'organizationLocationSimluationValuedResource' => 'organizations/{organization}/locations/{location}/simulations/{simluation}/valuedResources/{valued_resource}',
                'organizationMuteConfig' => 'organizations/{organization}/muteConfigs/{mute_config}',
                'organizationResourceValueConfig' => 'organizations/{organization}/resourceValueConfigs/{resource_value_config}',
                'organizationSimulation' => 'organizations/{organization}/simulations/{simulation}',
                'organizationSimulationValuedResource' => 'organizations/{organization}/simulations/{simulation}/valuedResources/{valued_resource}',
                'organizationSource' => 'organizations/{organization}/sources/{source}',
                'organizationSourceFinding' => 'organizations/{organization}/sources/{source}/findings/{finding}',
                'organizationSourceFindingExternalsystem' => 'organizations/{organization}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'organizationSourceFindingSecurityMarks' => 'organizations/{organization}/sources/{source}/findings/{finding}/securityMarks',
                'organizationSourceLocationFinding' => 'organizations/{organization}/sources/{source}/locations/{location}/findings/{finding}',
                'organizationSourceLocationFindingExternalsystem' => 'organizations/{organization}/sources/{source}/locations/{location}/findings/{finding}/externalSystems/{externalsystem}',
                'organizationSourceLocationFindingSecurityMarks' => 'organizations/{organization}/sources/{source}/locations/{location}/findings/{finding}/securityMarks',
                'organizationValuedResource' => 'organizations/{organization}/locations/{location}/simulations/{simulation}/valuedResources/{valued_resource}',
                'policy' => 'organizations/{organization}/policies/{constraint_name}',
                'project' => 'projects/{project}',
                'projectAssetSecurityMarks' => 'projects/{project}/assets/{asset}/securityMarks',
                'projectConstraintName' => 'projects/{project}/policies/{constraint_name}',
                'projectDlpJob' => 'projects/{project}/dlpJobs/{dlp_job}',
                'projectLocationDlpJob' => 'projects/{project}/locations/{location}/dlpJobs/{dlp_job}',
                'projectLocationExport' => 'projects/{project}/locations/{location}/bigQueryExports/{export}',
                'projectLocationMuteConfig' => 'projects/{project}/locations/{location}/muteConfigs/{mute_config}',
                'projectLocationNotificationConfig' => 'projects/{project}/locations/{location}/notificationConfigs/{notification_config}',
                'projectLocationTableProfile' => 'projects/{project}/locations/{location}/tableProfiles/{table_profile}',
                'projectMuteConfig' => 'projects/{project}/muteConfigs/{mute_config}',
                'projectSource' => 'projects/{project}/sources/{source}',
                'projectSourceFinding' => 'projects/{project}/sources/{source}/findings/{finding}',
                'projectSourceFindingExternalsystem' => 'projects/{project}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'projectSourceFindingSecurityMarks' => 'projects/{project}/sources/{source}/findings/{finding}/securityMarks',
                'projectSourceLocationFinding' => 'projects/{project}/sources/{source}/locations/{location}/findings/{finding}',
                'projectSourceLocationFindingExternalsystem' => 'projects/{project}/sources/{source}/locations/{location}/findings/{finding}/externalSystems/{externalsystem}',
                'projectSourceLocationFindingSecurityMarks' => 'projects/{project}/sources/{source}/locations/{location}/findings/{finding}/securityMarks',
                'projectTableProfile' => 'projects/{project}/tableProfiles/{table_profile}',
                'resourceValueConfig' => 'organizations/{organization}/resourceValueConfigs/{resource_value_config}',
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
