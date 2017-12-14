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
                        'getTable_name',
                    ],
                ],
            ],
            'SampleRowKeys' => [
                'method' => 'get',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:sampleRowKeys',
                'placeholders' => [
                    'table_name' => [
                        'getTable_name',
                    ],
                ],
            ],
            'MutateRow' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTable_name',
                    ],
                ],
            ],
            'MutateRows' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRows',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTable_name',
                    ],
                ],
            ],
            'CheckAndMutateRow' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:checkAndMutateRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTable_name',
                    ],
                ],
            ],
            'ReadModifyWriteRow' => [
                'method' => 'post',
                'uri' => '/v2/{table_name=projects/*/instances/*/tables/*}:readModifyWriteRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getTable_name',
                    ],
                ],
            ],
        ],
    ],
];
