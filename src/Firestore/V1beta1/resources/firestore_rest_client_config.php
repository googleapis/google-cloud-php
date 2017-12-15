<?php

return [
    'interfaces' => [
        'google.firestore.v1beta1.Firestore' => [
            'GetDocument' => [
                'method' => 'get',
                'uri' => '/v1beta1/{name=projects/*/databases/*/documents/*/**}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'ListDocuments' => [
                'method' => 'get',
                'uri' => '/v1beta1/{parent=projects/*/databases/*/documents/*/**}/{collection_id}',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                    'collection_id' => [
                        'getCollectionId',
                    ],
                ],
            ],
            'CreateDocument' => [
                'method' => 'post',
                'uri' => '/v1beta1/{parent=projects/*/databases/*/documents/**}/{collection_id}',
                'body' => 'document',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                    'collection_id' => [
                        'getCollectionId',
                    ],
                ],
            ],
            'UpdateDocument' => [
                'method' => 'patch',
                'uri' => '/v1beta1/{document.name=projects/*/databases/*/documents/*/**}',
                'body' => 'document',
                'placeholders' => [
                    'document.name' => [
                        'getDocument',
                        'getName',
                    ],
                ],
            ],
            'DeleteDocument' => [
                'method' => 'delete',
                'uri' => '/v1beta1/{name=projects/*/databases/*/documents/*/**}',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'BatchGetDocuments' => [
                'method' => 'post',
                'uri' => '/v1beta1/{database=projects/*/databases/*}/documents:batchGet',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'BeginTransaction' => [
                'method' => 'post',
                'uri' => '/v1beta1/{database=projects/*/databases/*}/documents:beginTransaction',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'Commit' => [
                'method' => 'post',
                'uri' => '/v1beta1/{database=projects/*/databases/*}/documents:commit',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'Rollback' => [
                'method' => 'post',
                'uri' => '/v1beta1/{database=projects/*/databases/*}/documents:rollback',
                'body' => '*',
                'placeholders' => [
                    'database' => [
                        'getDatabase',
                    ],
                ],
            ],
            'RunQuery' => [
                'method' => 'post',
                'uri' => '/v1beta1/{parent=projects/*/databases/*/documents}:runQuery',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
            'ListCollectionIds' => [
                'method' => 'post',
                'uri' => '/v1beta1/{parent=projects/*/databases/*/documents}:listCollectionIds',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getParent',
                    ],
                ],
            ],
        ],
    ],
];
