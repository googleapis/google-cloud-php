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
            'ReadRows' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{read_stream=projects/*/locations/*/sessions/*/streams/*}',
                'placeholders' => [
                    'read_stream' => [
                        'getters' => [
                            'getReadStream',
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
