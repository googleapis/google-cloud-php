<?php

return [
    'interfaces' => [
        'google.firestore.v1.Firestore' => [
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
            'ListDocuments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/documents/*/**}/{collection_id}',
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
        ],
    ],
];
