<?php

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
];
