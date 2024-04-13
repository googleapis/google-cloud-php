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
        'google.dataflow.v1beta3.JobsV1Beta3' => [
            'AggregatedListJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1b3/projects/{project_id}/jobs:aggregated',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'CreateJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/jobs',
                'body' => 'job',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1b3/projects/{project_id}/jobs',
                        'body' => 'job',
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
            'GetJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/jobs/{job_id}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1b3/projects/{project_id}/jobs/{job_id}',
                    ],
                ],
                'placeholders' => [
                    'job_id' => [
                        'getters' => [
                            'getJobId',
                        ],
                    ],
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
            'ListJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/jobs',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1b3/projects/{project_id}/jobs',
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
            'SnapshotJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/jobs/{job_id}:snapshot',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1b3/projects/{project_id}/jobs/{job_id}:snapshot',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'job_id' => [
                        'getters' => [
                            'getJobId',
                        ],
                    ],
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
            'UpdateJob' => [
                'method' => 'put',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/jobs/{job_id}',
                'body' => 'job',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1b3/projects/{project_id}/jobs/{job_id}',
                        'body' => 'job',
                    ],
                ],
                'placeholders' => [
                    'job_id' => [
                        'getters' => [
                            'getJobId',
                        ],
                    ],
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
