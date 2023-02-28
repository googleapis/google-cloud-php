<?php

return [
    'interfaces' => [
        'google.iam.credentials.v1.IAMCredentials' => [
            'GenerateAccessToken' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/serviceAccounts/*}:generateAccessToken',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GenerateIdToken' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/serviceAccounts/*}:generateIdToken',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SignBlob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/serviceAccounts/*}:signBlob',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SignJwt' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/serviceAccounts/*}:signJwt',
                'body' => '*',
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
