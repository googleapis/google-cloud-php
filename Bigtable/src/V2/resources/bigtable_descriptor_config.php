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
                    [
                        'keyName' => 'authorized_view_name',
                        'fieldAccessors' => [
                            'getAuthorizedViewName',
                        ],
                        'matchers' => [
                            '/^(?<authorized_view_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+\/authorizedViews\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'ExecuteQuery' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\ExecuteQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getInstanceName',
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
                    [
                        'keyName' => 'authorized_view_name',
                        'fieldAccessors' => [
                            'getAuthorizedViewName',
                        ],
                        'matchers' => [
                            '/^(?<authorized_view_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+\/authorizedViews\/[^\/]+)$/',
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
                    [
                        'keyName' => 'authorized_view_name',
                        'fieldAccessors' => [
                            'getAuthorizedViewName',
                        ],
                        'matchers' => [
                            '/^(?<authorized_view_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+\/authorizedViews\/[^\/]+)$/',
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
            'PrepareQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Bigtable\V2\PrepareQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getInstanceName',
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
                    [
                        'keyName' => 'authorized_view_name',
                        'fieldAccessors' => [
                            'getAuthorizedViewName',
                        ],
                        'matchers' => [
                            '/^(?<authorized_view_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+\/authorizedViews\/[^\/]+)$/',
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
                    [
                        'keyName' => 'authorized_view_name',
                        'fieldAccessors' => [
                            'getAuthorizedViewName',
                        ],
                        'matchers' => [
                            '/^(?<authorized_view_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+\/authorizedViews\/[^\/]+)$/',
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
                    [
                        'keyName' => 'authorized_view_name',
                        'fieldAccessors' => [
                            'getAuthorizedViewName',
                        ],
                        'matchers' => [
                            '/^(?<authorized_view_name>projects\/[^\/]+\/instances\/[^\/]+\/tables\/[^\/]+\/authorizedViews\/[^\/]+)$/',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'authorizedView' => 'projects/{project}/instances/{instance}/tables/{table}/authorizedViews/{authorized_view}',
                'instance' => 'projects/{project}/instances/{instance}',
                'materializedView' => 'projects/{project}/instances/{instance}/materializedViews/{materialized_view}',
                'table' => 'projects/{project}/instances/{instance}/tables/{table}',
            ],
        ],
    ],
];
