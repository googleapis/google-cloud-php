<?php

return [
    'interfaces' => [
        'google.bigtable.admin.v2.BigtableTableAdmin' => [
            'CreateTable' => [
                'method' => 'post',
                'uri' => '/v2/{parent=projects/*/instances/*}/tables',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'CreateTableFromSnapshot' => [
                'method' => 'post',
                'uri' => '/v2/{parent=projects/*/instances/*}/tables:createFromSnapshot',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'ListTables' => [
                'method' => 'get',
                'uri' => '/v2/{parent=projects/*/instances/*}/tables',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'GetTable' => [
                'method' => 'get',
                'uri' => '/v2/{name=projects/*/instances/*/tables/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'DeleteTable' => [
                'method' => 'delete',
                'uri' => '/v2/{name=projects/*/instances/*/tables/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ModifyColumnFamilies' => [
                'method' => 'post',
                'uri' => '/v2/{name=projects/*/instances/*/tables/*}:modifyColumnFamilies',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'DropRowRange' => [
                'method' => 'post',
                'uri' => '/v2/{name=projects/*/instances/*/tables/*}:dropRowRange',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'GenerateConsistencyToken' => [
                'method' => 'post',
                'uri' => '/v2/{name=projects/*/instances/*/tables/*}:generateConsistencyToken',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'CheckConsistency' => [
                'method' => 'post',
                'uri' => '/v2/{name=projects/*/instances/*/tables/*}:checkConsistency',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'SnapshotTable' => [
                'method' => 'post',
                'uri' => '/v2/{name=projects/*/instances/*/tables/*}:snapshot',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'GetSnapshot' => [
                'method' => 'get',
                'uri' => '/v2/{name=projects/*/instances/*/clusters/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListSnapshots' => [
                'method' => 'get',
                'uri' => '/v2/{parent=projects/*/instances/*/clusters/*}/snapshots',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'DeleteSnapshot' => [
                'method' => 'delete',
                'uri' => '/v2/{name=projects/*/instances/*/clusters/*/snapshots/*}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
        ],
    ],
];
