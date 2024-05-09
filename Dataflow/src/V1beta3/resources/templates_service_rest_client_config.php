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
        'google.dataflow.v1beta3.TemplatesService' => [
            'CreateJobFromTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/templates',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1b3/projects/{project_id}/templates',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'GetTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/templates:get',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1b3/projects/{project_id}/templates:get',
                    ],
                ],
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'LaunchTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/templates:launch',
                'body' => 'launch_parameters',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1b3/projects/{project_id}/templates:launch',
                        'body' => 'launch_parameters',
                    ],
                ],
                'placeholders' => [
                    'location' => [
                        'getters' => [
                            'getLocation',
                        ],
                    ],
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
