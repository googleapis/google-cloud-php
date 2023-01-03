<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1beta4.SqlBackupRunsService' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/backupRuns/{id}',
                'placeholders' => [
                    'id' => [
                        'getters' => [
                            'getId',
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
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/backupRuns/{id}',
                'placeholders' => [
                    'id' => [
                        'getters' => [
                            'getId',
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
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/backupRuns',
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
                'uriTemplate' => '/sql/v1beta4/projects/{project}/instances/{instance}/backupRuns',
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
        ],
    ],
];
