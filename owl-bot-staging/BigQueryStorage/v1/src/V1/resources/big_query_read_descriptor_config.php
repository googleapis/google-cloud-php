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
