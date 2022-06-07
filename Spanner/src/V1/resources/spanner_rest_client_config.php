<?php

return [
    'interfaces' => [
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}:cancel',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.spanner.v1.Spanner' => [
            'BatchCreateSessions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/sessions:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'BeginTransaction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:beginTransaction',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Commit' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:commit',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'CreateSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/sessions',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'DeleteSession' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExecuteBatchDml' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeBatchDml',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ExecuteSql' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeSql',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ExecuteStreamingSql' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeStreamingSql',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'GetSession' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSessions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/sessions',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'PartitionQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:partitionQuery',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'PartitionRead' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:partitionRead',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Read' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:read',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Rollback' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'StreamingRead' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:streamingRead',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
