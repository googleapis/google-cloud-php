<?php

return [
    'interfaces' => [
        'google.monitoring.v3.SnoozeService' => [
            'CreateSnooze' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\Snooze',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetSnooze' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\Snooze',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSnoozes' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSnoozes',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\ListSnoozesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSnooze' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\Snooze',
                'headerParams' => [
                    [
                        'keyName' => 'snooze.name',
                        'fieldAccessors' => [
                            'getSnooze',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'alertPolicy' => 'projects/{project}/alertPolicies/{alert_policy}',
                'folderAlertPolicy' => 'folders/{folder}/alertPolicies/{alert_policy}',
                'organizationAlertPolicy' => 'organizations/{organization}/alertPolicies/{alert_policy}',
                'project' => 'projects/{project}',
                'projectAlertPolicy' => 'projects/{project}/alertPolicies/{alert_policy}',
                'snooze' => 'projects/{project}/snoozes/{snooze}',
                'workspace' => 'projects/{project}',
            ],
        ],
    ],
];
