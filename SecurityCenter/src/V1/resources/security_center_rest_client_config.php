<?php

return [
    'interfaces' => [
        'google.cloud.securitycenter.v1.SecurityCenter' => [
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
                        'uriTemplate' => '/v1/{parent=folders/*}/muteConfigs',
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
];
