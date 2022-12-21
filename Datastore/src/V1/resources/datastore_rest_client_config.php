<?php

return [
    'interfaces' => [
        'google.datastore.v1.Datastore' => [
            'AllocateIds' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:allocateIds',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'BeginTransaction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:beginTransaction',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'Commit' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:commit',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'Lookup' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:lookup',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'ReserveIds' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:reserveIds',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'Rollback' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:rollback',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'RunAggregationQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:runAggregationQuery',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
            'RunQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/projects/{project_id}:runQuery',
                'body' => '*',
                'placeholders' => [
                    'project_id' => [
                        'getters' => [
                            'getProjectId',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/operations/*}:cancel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
