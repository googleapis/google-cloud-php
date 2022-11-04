<?php

return [
    'interfaces' => [
        'google.dataflow.v1beta3.MessagesV1Beta3' => [
            'ListJobMessages' => [
                'method' => 'get',
                'uriTemplate' => '/v1b3/projects/{project_id}/locations/{location}/jobs/{job_id}/messages',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1b3/projects/{project_id}/jobs/{job_id}/messages',
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
