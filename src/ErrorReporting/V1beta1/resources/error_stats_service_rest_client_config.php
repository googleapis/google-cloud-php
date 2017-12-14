<?php

return [
    'interfaces' => [
        'google.devtools.clouderrorreporting.v1beta1.ErrorStatsService' => [
            'ListGroupStats' => [
                'method' => 'get',
                'uri' => '/v1beta1/{project_name=projects/*}/groupStats',
                'placeholders' => [
                    'project_name' => [
                        'getProject_name',
                    ],
                ],
            ],
            'ListEvents' => [
                'method' => 'get',
                'uri' => '/v1beta1/{project_name=projects/*}/events',
                'placeholders' => [
                    'project_name' => [
                        'getProject_name',
                    ],
                ],
            ],
            'DeleteEvents' => [
                'method' => 'delete',
                'uri' => '/v1beta1/{project_name=projects/*}/events',
                'placeholders' => [
                    'project_name' => [
                        'getProject_name',
                    ],
                ],
            ],
        ],
    ],
];
