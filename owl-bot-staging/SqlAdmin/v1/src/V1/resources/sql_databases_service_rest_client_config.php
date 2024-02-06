<?php

return [
    'interfaces' => [
        'google.cloud.sql.v1.SqlDatabasesService' => [
            'Delete' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/databases/{database}',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/databases/{database}',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/databases',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/databases',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/databases/{database}',
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
                'uriTemplate' => '/v1/projects/{project}/instances/{instance}/databases/{database}',
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
