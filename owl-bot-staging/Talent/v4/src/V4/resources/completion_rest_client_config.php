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
    ],
];
