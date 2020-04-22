<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.storage.v1.BigQueryRead' => [
            'CreateReadSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{read_session.table=projects/*/datasets/*/tables/*}',
                'body' => '*',
                'placeholders' => [
                    'read_session.table' => [
                        'getters' => [
                            'getReadSession',
                            'getTable',
                        ],
                    ],
                ],
            ],
            'SplitReadStream' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/sessions/*/streams/*}',
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
