<?php

return [
    'interfaces' => [
        'google.bigtable.v2.Bigtable' => [
            'MutateRow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'CheckAndMutateRow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:checkAndMutateRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'ReadModifyWriteRow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:readModifyWriteRow',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
