<?php

return [
    'interfaces' => [
        'google.firestore.v1.Firestore' => [
            'BatchGetDocuments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/databases/*}/documents:batchGet',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'BatchWrite' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/databases/*}/documents:batchWrite',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'BeginTransaction' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/databases/*}/documents:beginTransaction',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'Commit' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/databases/*}/documents:commit',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'CreateDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents/**}/{collection_id}',
                'body' => 'document',
                'placeholders' => [
                    'collection_id' => [
                        'getters' => [
                            'getCollectionId',
                        ],
                    ],
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'document_id',
                ],
            ],
            'DeleteDocument' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/databases/*/documents/*/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDocument' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/databases/*/documents/*/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCollectionIds' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents}:listCollectionIds',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents/*/**}:listCollectionIds',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDocuments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents/*/**}/{collection_id}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents}/{collection_id}',
                    ],
                ],
                'placeholders' => [
                    'collection_id' => [
                        'getters' => [
                            'getCollectionId',
                        ],
                    ],
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PartitionQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents}:partitionQuery',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents/*/**}:partitionQuery',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'Rollback' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{database=projects/*/databases/*}/documents:rollback',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getters' => [
                            'getDatabase',
                        ],
                    ],
                ],
            ],
            'RunAggregationQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents}:runAggregationQuery',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents/*/**}:runAggregationQuery',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RunQuery' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents}:runQuery',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents/*/**}:runQuery',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDocument' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{document.name=projects/*/databases/*/documents/*/**}',
                'body' => 'document',
                'placeholders' => [
                    'document.name' => [
                        'getters' => [
                            'getDocument',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/databases/*/operations/*}:cancel',
                'body' => '*',
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
                'uriTemplate' => '/v1/{name=projects/*/databases/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/databases/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/databases/*}/operations',
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
