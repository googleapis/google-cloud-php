<?php

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
];
