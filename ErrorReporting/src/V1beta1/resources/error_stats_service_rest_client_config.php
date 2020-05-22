<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ErrorStatsService' => [
            'DeleteEvents' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta1/{project_name=projects/*}/events',
                'placeholders' => [
                    'project_name' => [
                        'getters' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'ListGroupStats' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{project_name=projects/*}/groupStats',
                'placeholders' => [
                    'project_name' => [
                        'getters' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
            'ListEvents' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta1/{project_name=projects/*}/events',
                'placeholders' => [
                    'project_name' => [
                        'getters' => [
                            'getProjectName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
