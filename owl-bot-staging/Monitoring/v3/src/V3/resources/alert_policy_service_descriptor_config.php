<?php

return [
    'interfaces' => [
        'google.monitoring.v3.AlertPolicyService' => [
            'CreateAlertPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\AlertPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAlertPolicy' => [
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
            'GetAlertPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\AlertPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAlertPolicies' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getAlertPolicies',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\ListAlertPoliciesResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAlertPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Monitoring\V3\AlertPolicy',
                'headerParams' => [
                    [
                        'keyName' => 'alert_policy.name',
                        'fieldAccessors' => [
                            'getAlertPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'alertPolicy' => 'projects/{project}/alertPolicies/{alert_policy}',
                'folderAlertPolicy' => 'folders/{folder}/alertPolicies/{alert_policy}',
                'organizationAlertPolicy' => 'organizations/{organization}/alertPolicies/{alert_policy}',
                'projectAlertPolicy' => 'projects/{project}/alertPolicies/{alert_policy}',
            ],
        ],
    ],
];
