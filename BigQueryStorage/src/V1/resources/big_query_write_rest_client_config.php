<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.storage.v1.BigQueryWrite' => [
            'BatchCommitWriteStreams' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/datasets/*/tables/*}',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'write_streams',
                ],
            ],
            'CreateWriteStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/datasets/*/tables/*}',
                'body' => 'write_stream',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'FinalizeWriteStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/datasets/*/tables/*/streams/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FlushRows' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{write_stream=projects/*/datasets/*/tables/*/streams/*}',
                'body' => '*',
                'placeholders' => [
                    'write_stream' => [
                        'getters' => [
                            'getWriteStream',
                        ],
                    ],
                ],
            ],
            'GetWriteStream' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/datasets/*/tables/*/streams/*}',
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
