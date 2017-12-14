<?php

return [
    'interfaces' => [
        'google.spanner.v1.Spanner' => [
            'CreateSession' => [
                'method' => 'post',
                'uri' => '/v1/{database=projects/*/instances/*/databases/*}/sessions',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'GetSession' => [
                'method' => 'get',
                'uri' => '/v1/{name=projects/*/instances/*/databases/*/sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListSessions' => [
                'method' => 'get',
                'uri' => '/v1/{database=projects/*/instances/*/databases/*}/sessions',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'DeleteSession' => [
                'method' => 'delete',
                'uri' => '/v1/{name=projects/*/instances/*/databases/*/sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ExecuteSql' => [
                'method' => 'post',
                'uri' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeSql',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getSession',
                    ],
                ],
            ],
            'ExecuteStreamingSql' => [
                'method' => 'post',
                'uri' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeStreamingSql',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getSession',
                    ],
                ],
            ],
            'Read' => [
                'method' => 'post',
                'uri' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:read',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getSession',
                    ],
                ],
            ],
            'StreamingRead' => [
                'method' => 'post',
                'uri' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:streamingRead',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getSession',
                    ],
                ],
            ],
            'BeginTransaction' => [
                'method' => 'post',
                'uri' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:beginTransaction',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getSession',
                    ],
                ],
            ],
            'Commit' => [
                'method' => 'post',
                'uri' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:commit',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getSession',
                    ],
                ],
            ],
            'Rollback' => [
                'method' => 'post',
                'uri' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getSession',
                    ],
                ],
            ],
        ],
    ],
];
