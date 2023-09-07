<?php

return [
    'interfaces' => [
        'google.bigtable.v2.Bigtable' => [
            'CheckAndMutateRow' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\CheckAndMutateRowResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                        'matchers' => [
                            '/^(?<table_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+)$/',
                        ],
                    ],
                    [
                        'keyName' => 'app_profile_id',
                        'fieldAccessors' => [
                            'getAppProfileId',
                        ],
                    ],
                ],
            ],
            'GenerateInitialChangeStreamPartitions' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\GenerateInitialChangeStreamPartitionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'MutateRow' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\MutateRowResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                        'matchers' => [
                            '/^(?<table_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+)$/',
                        ],
                    ],
                    [
                        'keyName' => 'app_profile_id',
                        'fieldAccessors' => [
                            'getAppProfileId',
                        ],
                    ],
                ],
            ],
            'MutateRows' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\MutateRowsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                        'matchers' => [
                            '/^(?<table_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+)$/',
                        ],
                    ],
                    [
                        'keyName' => 'app_profile_id',
                        'fieldAccessors' => [
                            'getAppProfileId',
                        ],
                    ],
                ],
            ],
            'PingAndWarm' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\PingAndWarmResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                        'matchers' => [
                            '/^(?<name>projects\/[^\/]+\/instances\/[^\/]+)$/',
                        ],
                    ],
                    [
                        'keyName' => 'app_profile_id',
                        'fieldAccessors' => [
                            'getAppProfileId',
                        ],
                    ],
                ],
            ],
            'ReadChangeStream' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\ReadChangeStreamResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                    ],
                ],
            ],
            'ReadModifyWriteRow' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\ReadModifyWriteRowResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                        'matchers' => [
                            '/^(?<table_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+)$/',
                        ],
                    ],
                    [
                        'keyName' => 'app_profile_id',
                        'fieldAccessors' => [
                            'getAppProfileId',
                        ],
                    ],
                ],
            ],
            'ReadRows' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\ReadRowsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                        'matchers' => [
                            '/^(?<table_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+)$/',
                        ],
                    ],
                    [
                        'keyName' => 'app_profile_id',
                        'fieldAccessors' => [
                            'getAppProfileId',
                        ],
                    ],
                ],
            ],
            'SampleRowKeys' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\SampleRowKeysResponse',
                'headerParams' => [
                    [
                        'keyName' => 'table_name',
                        'fieldAccessors' => [
                            'getTableName',
                        ],
                        'matchers' => [
                            '/^(?<table_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+)$/',
                        ],
                    ],
                    [
                        'keyName' => 'app_profile_id',
                        'fieldAccessors' => [
                            'getAppProfileId',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'instance' => 'projects/{project}/instances/{instance}',
                'table' => 'projects/{project}/instances/{instance}/tables/{table}',
            ],
        ],
    ],
];
