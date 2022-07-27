<?php

return [
    'interfaces' => [
        'google.bigtable.v2.Bigtable' => [
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
            'MutateRows' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:mutateRows',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'PingAndWarm' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/instances/*}:ping',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'ReadRows' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:readRows',
                'body' => '*',
                'placeholders' => [
                    'table_name' => [
                        'getters' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'SampleRowKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{table_name=projects/*/instances/*/tables/*}:sampleRowKeys',
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
