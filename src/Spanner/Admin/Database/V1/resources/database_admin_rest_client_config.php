<?php

return [
    'interfaces' => [
        'google.spanner.admin.database.v1.DatabaseAdmin' => [
            'ListDatabases' => [
                'method' => 'get',
                'uri' => '/v1/{parent=projects/*/instances/*}/databases',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'CreateDatabase' => [
                'method' => 'post',
                'uri' => '/v1/{parent=projects/*/instances/*}/databases',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetDatabase' => [
                'method' => 'get',
                'uri' => '/v1/{name=projects/*/instances/*/databases/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'UpdateDatabaseDdl' => [
                'method' => 'patch',
                'uri' => '/v1/{database=projects/*/instances/*/databases/*}/ddl',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'DropDatabase' => [
                'method' => 'delete',
                'uri' => '/v1/{database=projects/*/instances/*/databases/*}',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'GetDatabaseDdl' => [
                'method' => 'get',
                'uri' => '/v1/{database=projects/*/instances/*/databases/*}/ddl',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v1/{resource=projects/*/instances/*/databases/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v1/{resource=projects/*/instances/*/databases/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uri' => '/v1/{resource=projects/*/instances/*/databases/*}:testIamPermissions',
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
