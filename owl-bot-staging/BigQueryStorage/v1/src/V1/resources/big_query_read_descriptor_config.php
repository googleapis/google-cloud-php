<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.storage.v1.BigQueryRead' => [
            'CreateReadSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\ReadSession',
                'headerParams' => [
                    [
                        'keyName' => 'read_session.table',
                        'fieldAccessors' => [
                            'getReadSession',
                            'getTable',
                        ],
                    ],
                ],
            ],
            'ReadRows' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\ReadRowsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'read_stream',
                        'fieldAccessors' => [
                            'getReadStream',
                        ],
                    ],
                ],
            ],
            'SplitReadStream' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\SplitReadStreamResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'project' => 'projects/{project}',
                'readSession' => 'projects/{project}/locations/{location}/sessions/{session}',
                'readStream' => 'projects/{project}/locations/{location}/sessions/{session}/streams/{stream}',
                'table' => 'projects/{project}/datasets/{dataset}/tables/{table}',
            ],
        ],
    ],
];
