<?php

return [
    'interfaces' => [
        'google.cloud.securitycenter.v1p1beta1.SecurityCenter' => [
            'CreateFinding' => [
                'method' => 'post',
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*/sources/*}/findings',
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
            'CreateNotificationConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*}/notificationConfigs',
                'body' => 'notification_config',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*}/sources',
                'body' => 'source',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteNotificationConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/notificationConfigs/*}',
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
                'uriTemplate' => '/v1p1beta1/{resource=organizations/*/sources/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetNotificationConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/notificationConfigs/*}',
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
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/organizationSettings}',
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
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/sources/*}',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*}/assets:group',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1p1beta1/{parent=folders/*}/assets:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1p1beta1/{parent=projects/*}/assets:group',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*/sources/*}/findings:group',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1p1beta1/{parent=folders/*/sources/*}/findings:group',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1p1beta1/{parent=projects/*/sources/*}/findings:group',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*}/assets',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{parent=folders/*}/assets',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{parent=projects/*}/assets',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*/sources/*}/findings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{parent=folders/*/sources/*}/findings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{parent=projects/*/sources/*}/findings',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*}/notificationConfigs',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*}/sources',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{parent=folders/*}/sources',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1p1beta1/{parent=projects/*}/sources',
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
                'uriTemplate' => '/v1p1beta1/{parent=organizations/*}/assets:runDiscovery',
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
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/sources/*/findings/*}:setState',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1p1beta1/{name=folders/*/sources/*/findings/*}:setState',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1p1beta1/{name=projects/*/sources/*/findings/*}:setState',
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
                'uriTemplate' => '/v1p1beta1/{resource=organizations/*/sources/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v1p1beta1/{resource=organizations/*/sources/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateFinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v1p1beta1/{finding.name=organizations/*/sources/*/findings/*}',
                'body' => 'finding',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1p1beta1/{finding.name=folders/*/sources/*/findings/*}',
                        'body' => 'finding',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1p1beta1/{finding.name=projects/*/sources/*/findings/*}',
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
            'UpdateNotificationConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1p1beta1/{notification_config.name=organizations/*/notificationConfigs/*}',
                'body' => 'notification_config',
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
                'uriTemplate' => '/v1p1beta1/{organization_settings.name=organizations/*/organizationSettings}',
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
                'uriTemplate' => '/v1p1beta1/{security_marks.name=organizations/*/assets/*/securityMarks}',
                'body' => 'security_marks',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1p1beta1/{security_marks.name=folders/*/assets/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1p1beta1/{security_marks.name=projects/*/assets/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1p1beta1/{security_marks.name=organizations/*/sources/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1p1beta1/{security_marks.name=folders/*/sources/*/findings/*/securityMarks}',
                        'body' => 'security_marks',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1p1beta1/{security_marks.name=projects/*/sources/*/findings/*/securityMarks}',
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
                'uriTemplate' => '/v1p1beta1/{source.name=organizations/*/sources/*}',
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
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/operations/*}',
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
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/operations/*}',
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
                'uriTemplate' => '/v1p1beta1/{name=organizations/*/operations}',
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
