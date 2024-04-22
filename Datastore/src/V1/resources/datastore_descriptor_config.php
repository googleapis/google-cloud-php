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
        'google.datastore.v1.Datastore' => [
            'AllocateIds' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\AllocateIdsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'BeginTransaction' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\BeginTransactionResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'Commit' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\CommitResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'Lookup' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\LookupResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'ReserveIds' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\ReserveIdsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'Rollback' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\RollbackResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'RunAggregationQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\RunAggregationQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
            'RunQuery' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Datastore\V1\RunQueryResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project_id',
                        'fieldAccessors' => [
                            'getProjectId',
                        ],
                    ],
                    [
                        'keyName' => 'database_id',
                        'fieldAccessors' => [
                            'getDatabaseId',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
