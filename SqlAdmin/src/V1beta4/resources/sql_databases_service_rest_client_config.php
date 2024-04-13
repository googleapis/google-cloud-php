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
        'google.cloud.sql.v1beta4.SqlDatabasesService' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/databases/{database}',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Get' => [
                'method' => 'get',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/databases/{database}',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Insert' => [
                'method' => 'post',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/databases',
                'body' => 'body',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'List' => [
                'method' => 'get',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/databases',
                'placeholders' => [
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Patch' => [
                'method' => 'patch',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/databases/{database}',
                'body' => 'body',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Update' => [
                'method' => 'put',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/databases/{database}',
                'body' => 'body',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                    'instance' => [
                        'getters' => [
                            'getInstance',
                        ],
                    ],
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
