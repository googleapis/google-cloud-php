<?php

return [
    'interfaces' => [
        'google.spanner.admin.instance.v1.InstanceAdmin' => [
            'ListInstanceConfigs' => [
                'method' => 'get',
                'uri' => '/v1/{parent=projects/*}/instanceConfigs',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetInstanceConfig' => [
                'method' => 'get',
                'uri' => '/v1/{name=projects/*/instanceConfigs/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListInstances' => [
                'method' => 'get',
                'uri' => '/v1/{parent=projects/*}/instances',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetInstance' => [
                'method' => 'get',
                'uri' => '/v1/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CreateInstance' => [
                'method' => 'post',
                'uri' => '/v1/{parent=projects/*}/instances',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'UpdateInstance' => [
                'method' => 'patch',
                'uri' => '/v1/{instance.name=projects/*/instances/*}',
                'body' => '*',
                'placeholders' => [
                    'instance.name' => [
                        'getInstance',
                        'getName',
                    ],
                ],
            ],
            'DeleteInstance' => [
                'method' => 'delete',
                'uri' => '/v1/{name=projects/*/instances/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v1/{resource=projects/*/instances/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v1/{resource=projects/*/instances/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uri' => '/v1/{resource=projects/*/instances/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
        ],
    ],
];
