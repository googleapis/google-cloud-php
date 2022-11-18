<?php

return [
    'interfaces' => [
        'google.cloud.shell.v1.CloudShellService' => [
            'AddPublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=users/*/environments/*}:addPublicKey',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'AuthorizeEnvironment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=users/*/environments/*}:authorize',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEnvironment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=users/*/environments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RemovePublicKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{environment=users/*/environments/*}:removePublicKey',
                'body' => '*',
                'placeholders' => [
                    'environment' => [
                        'getters' => [
                            'getEnvironment',
                        ],
                    ],
                ],
            ],
            'StartEnvironment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=users/*/environments/*}:start',
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
