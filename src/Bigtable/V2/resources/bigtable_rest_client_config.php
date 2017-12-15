<?php

return [
    'interfaces' => [
        'google.bigtable.v2.Bigtable' => [
            'ReadRows' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:readRows',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTableName',
                    ],
                ],
            ],
            'SampleRowKeys' => [
                'method' => 'get',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:sampleRowKeys',
                'placeholders' => [
                    'table_name' => [
                        'getTableName',
                    ],
                ],
            ],
            'MutateRow' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTableName',
                    ],
                ],
            ],
            'MutateRows' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRows',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTableName',
                    ],
                ],
            ],
            'CheckAndMutateRow' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:checkAndMutateRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTableName',
                    ],
                ],
            ],
            'ReadModifyWriteRow' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:readModifyWriteRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTableName',
                    ],
                ],
            ],
        ],
    ],
];
