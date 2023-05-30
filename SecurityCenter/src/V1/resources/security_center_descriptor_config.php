<?php

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
            'templateMap' => [
                'bigQueryExport' => 'organizations/{organization}/bigQueryExports/{export}',
                'dlpJob' => 'projects/{project}/dlpJobs/{dlp_job}',
                'effectiveSecurityHealthAnalyticsCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'externalSystem' => 'organizations/{organization}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'finding' => 'organizations/{organization}/sources/{source}/findings/{finding}',
                'folder' => 'folders/{folder}',
                'folderAssetSecurityMarks' => 'folders/{folder}/assets/{asset}/securityMarks',
                'folderCustomModule' => 'folders/{folder}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'folderEffectiveCustomModule' => 'folders/{folder}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'folderExport' => 'folders/{folder}/bigQueryExports/{export}',
                'folderMuteConfig' => 'folders/{folder}/muteConfigs/{mute_config}',
                'folderNotificationConfig' => 'folders/{folder}/notificationConfigs/{notification_config}',
                'folderSecurityHealthAnalyticsSettings' => 'folders/{folder}/securityHealthAnalyticsSettings',
                'folderSource' => 'folders/{folder}/sources/{source}',
                'folderSourceFinding' => 'folders/{folder}/sources/{source}/findings/{finding}',
                'folderSourceFindingExternalsystem' => 'folders/{folder}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'folderSourceFindingSecurityMarks' => 'folders/{folder}/sources/{source}/findings/{finding}/securityMarks',
                'muteConfig' => 'organizations/{organization}/muteConfigs/{mute_config}',
                'notificationConfig' => 'organizations/{organization}/notificationConfigs/{notification_config}',
                'organization' => 'organizations/{organization}',
                'organizationAssetSecurityMarks' => 'organizations/{organization}/assets/{asset}/securityMarks',
                'organizationCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'organizationEffectiveCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'organizationExport' => 'organizations/{organization}/bigQueryExports/{export}',
                'organizationMuteConfig' => 'organizations/{organization}/muteConfigs/{mute_config}',
                'organizationNotificationConfig' => 'organizations/{organization}/notificationConfigs/{notification_config}',
                'organizationSecurityHealthAnalyticsSettings' => 'organizations/{organization}/securityHealthAnalyticsSettings',
                'organizationSettings' => 'organizations/{organization}/organizationSettings',
                'organizationSource' => 'organizations/{organization}/sources/{source}',
                'organizationSourceFinding' => 'organizations/{organization}/sources/{source}/findings/{finding}',
                'organizationSourceFindingExternalsystem' => 'organizations/{organization}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'organizationSourceFindingSecurityMarks' => 'organizations/{organization}/sources/{source}/findings/{finding}/securityMarks',
                'project' => 'projects/{project}',
                'projectAssetSecurityMarks' => 'projects/{project}/assets/{asset}/securityMarks',
                'projectCustomModule' => 'projects/{project}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'projectDlpJob' => 'projects/{project}/dlpJobs/{dlp_job}',
                'projectEffectiveCustomModule' => 'projects/{project}/securityHealthAnalyticsSettings/effectiveCustomModules/{effective_custom_module}',
                'projectExport' => 'projects/{project}/bigQueryExports/{export}',
                'projectLocationDlpJob' => 'projects/{project}/locations/{location}/dlpJobs/{dlp_job}',
                'projectLocationTableProfile' => 'projects/{project}/locations/{location}/tableProfiles/{table_profile}',
                'projectMuteConfig' => 'projects/{project}/muteConfigs/{mute_config}',
                'projectNotificationConfig' => 'projects/{project}/notificationConfigs/{notification_config}',
                'projectSecurityHealthAnalyticsSettings' => 'projects/{project}/securityHealthAnalyticsSettings',
                'projectSource' => 'projects/{project}/sources/{source}',
                'projectSourceFinding' => 'projects/{project}/sources/{source}/findings/{finding}',
                'projectSourceFindingExternalsystem' => 'projects/{project}/sources/{source}/findings/{finding}/externalSystems/{externalsystem}',
                'projectSourceFindingSecurityMarks' => 'projects/{project}/sources/{source}/findings/{finding}/securityMarks',
                'projectTableProfile' => 'projects/{project}/tableProfiles/{table_profile}',
                'securityHealthAnalyticsCustomModule' => 'organizations/{organization}/securityHealthAnalyticsSettings/customModules/{custom_module}',
                'securityHealthAnalyticsSettings' => 'organizations/{organization}/securityHealthAnalyticsSettings',
                'securityMarks' => 'organizations/{organization}/assets/{asset}/securityMarks',
                'source' => 'organizations/{organization}/sources/{source}',
                'tableDataProfile' => 'projects/{project}/tableProfiles/{table_profile}',
                'topic' => 'projects/{project}/topics/{topic}',
            ],
        ],
    ],
];
