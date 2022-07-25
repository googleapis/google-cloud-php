<?php

return [
    'interfaces' => [
        'google.cloud.talent.v4.Completion' => [
            'CompleteQuery' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{tenant=projects/*/tenants/*}:completeQuery',
                'placeholders' => [
                    'tenant' => [
                        'getters' => [
                            'getTenant',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/operations/*}',
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
