<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.EntityTypes' => [
            'ListEntityTypes' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/agent}/entityTypes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetEntityType' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/agent/entityTypes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateEntityType' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent}/entityTypes',
                'body' => 'entity_type',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateEntityType' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{entity_type.name=projects/*/agent/entityTypes/*}',
                'body' => 'entity_type',
                'placeholders' => [
                    'entity_type.name' => [
                        'getters' => [
                            'getEntityType',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteEntityType' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/agent/entityTypes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'BatchUpdateEntityTypes' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent}/entityTypes:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteEntityTypes' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent}/entityTypes:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateEntities' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent/entityTypes/*}/entities:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchUpdateEntities' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent/entityTypes/*}/entities:batchUpdate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchDeleteEntities' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent/entityTypes/*}/entities:batchDelete',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/operations/*}:cancel',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
                    ],
                ],
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
                'uriTemplate' => '/v2/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
                    ],
                ],
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
                'uriTemplate' => '/v2/{name=projects/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
                    ],
                ],
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
