<?php

return [
    'interfaces' => [
        'google.monitoring.v3.SnoozeService' => [
            'CreateSnooze' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*}/snoozes',
                'body' => 'snooze',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetSnooze' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/snoozes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSnoozes' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*}/snoozes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSnooze' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{snooze.name=projects/*/snoozes/*}',
                'body' => 'snooze',
                'placeholders' => [
                    'snooze.name' => [
                        'getters' => [
                            'getSnooze',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
