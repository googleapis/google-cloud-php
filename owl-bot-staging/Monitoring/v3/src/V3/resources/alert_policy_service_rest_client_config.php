<?php

return [
    'interfaces' => [
        'google.monitoring.v3.AlertPolicyService' => [
            'CreateAlertPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/alertPolicies',
                'body' => 'alert_policy',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAlertPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/alertPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAlertPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/alertPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAlertPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/alertPolicies',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateAlertPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{alert_policy.name=projects/*/alertPolicies/*}',
                'body' => 'alert_policy',
                'placeholders' => [
                    'alert_policy.name' => [
                        'getters' => [
                            'getAlertPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
