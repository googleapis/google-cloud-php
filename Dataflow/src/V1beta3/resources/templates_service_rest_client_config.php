<?php

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
];
