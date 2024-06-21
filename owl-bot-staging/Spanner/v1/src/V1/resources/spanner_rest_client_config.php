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
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}:cancel',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}:cancel',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/operations}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instances/*/backups/*/operations}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/instanceConfigs/*/operations}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.spanner.v1.Spanner' => [
            'BatchCreateSessions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/sessions:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'BatchWrite' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:batchWrite',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'BeginTransaction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:beginTransaction',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Commit' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:commit',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'CreateSession' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/sessions',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'DeleteSession' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExecuteBatchDml' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeBatchDml',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ExecuteSql' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeSql',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'ExecuteStreamingSql' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:executeStreamingSql',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'GetSession' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/instances/*/databases/*/sessions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSessions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{database=projects/*/instances/*/databases/*}/sessions',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'PartitionQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:partitionQuery',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'PartitionRead' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:partitionRead',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Read' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:read',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'Rollback' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:rollback',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
            'StreamingRead' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{session=projects/*/instances/*/databases/*/sessions/*}:streamingRead',
                'body' => '*',
                'placeholders' => [
                    'session' => [
                        'getters' => [
                            'getSession',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
