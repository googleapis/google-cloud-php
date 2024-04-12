<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
