<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.storage.v1.BigQueryWrite' => [
            'AppendRows' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\AppendRowsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'write_stream',
                        'fieldAccessors' => [
                            'getWriteStream',
                        ],
                    ],
                ],
            ],
            'BatchCommitWriteStreams' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\BatchCommitWriteStreamsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateWriteStream' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\WriteStream',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'FinalizeWriteStream' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\FinalizeWriteStreamResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'FlushRows' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\FlushRowsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'write_stream',
                        'fieldAccessors' => [
                            'getWriteStream',
                        ],
                    ],
                ],
            ],
            'GetWriteStream' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\BigQuery\Storage\V1\WriteStream',
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
                'table' => 'projects/{project}/datasets/{dataset}/tables/{table}',
                'writeStream' => 'projects/{project}/datasets/{dataset}/tables/{table}/streams/{stream}',
            ],
        ],
    ],
];
