<?php

return [
    'interfaces' => [
        'google.cloud.resourcemanager.v3.Projects' => [
            'CreateProject' => [
                'method' => 'post',
                'uriTemplate' => '/v3/projects',
                'body' => 'project',
            ],
            'DeleteProject' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=projects/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetProject' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListProjects' => [
                'method' => 'get',
                'uriTemplate' => '/v3/projects',
                'queryParams' => [
                    'parent',
                ],
            ],
            'MoveProject' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}:move',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchProjects' => [
                'method' => 'get',
                'uriTemplate' => '/v3/projects:search',
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=projects/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{resource=projects/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UndeleteProject' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProject' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{project.name=projects/*}',
                'body' => 'project',
                'placeholders' => [
                    'project.name' => [
                        'getters' => [
                            'getProject',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=operations/**}',
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
