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
        'google.cloud.bigquery.migration.v2.MigrationService' => [
            'CreateMigrationWorkflow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/workflows',
                'body' => 'migration_workflow',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteMigrationWorkflow' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/workflows/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMigrationSubtask' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/workflows/*/subtasks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetMigrationWorkflow' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/workflows/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListMigrationSubtasks' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/workflows/*}/subtasks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListMigrationWorkflows' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/workflows',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'StartMigrationWorkflow' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/workflows/*}:start',
                'body' => '*',
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
