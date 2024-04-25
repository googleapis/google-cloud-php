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
        'google.spanner.v1.Spanner' => [
            'BatchCreateSessions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\BatchCreateSessionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'database',
                        'fieldAccessors' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'BatchWrite' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\BatchWriteResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'BeginTransaction' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\Transaction',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Commit' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\CommitResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'CreateSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\Session',
                'headerParams' => [
                    [
                        'keyName' => 'database',
                        'fieldAccessors' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'DeleteSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExecuteBatchDml' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\ExecuteBatchDmlResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ExecuteSql' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\ResultSet',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ExecuteStreamingSql' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\PartialResultSet',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'GetSession' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\Session',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSessions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSessions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\ListSessionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'database',
                        'fieldAccessors' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'PartitionQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\PartitionResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'PartitionRead' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\PartitionResponse',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Read' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\ResultSet',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Rollback' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'StreamingRead' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'ServerStreaming',
                ],
                'callType' => \Google\ApiCore\Call::SERVER_STREAMING_CALL,
                'responseType' => 'Google\Cloud\Spanner\V1\PartialResultSet',
                'headerParams' => [
                    [
                        'keyName' => 'session',
                        'fieldAccessors' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'database' => 'projects/{project}/instances/{instance}/databases/{database}',
                'session' => 'projects/{project}/instances/{instance}/databases/{database}/sessions/{session}',
            ],
        ],
    ],
];
