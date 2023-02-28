<?php

return [
    'interfaces' => [
        'google.firestore.admin.v1.FirestoreAdmin' => [
            'CreateIndex' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/collectionGroups/*}/indexes',
                'body' => 'index',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteIndex' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/databases/*/collectionGroups/*/indexes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportDocuments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/databases/*}:exportDocuments',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDatabase' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/databases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetField' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/databases/*/collectionGroups/*/fields/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIndex' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/databases/*/collectionGroups/*/indexes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportDocuments' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/databases/*}:importDocuments',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDatabases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/databases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListFields' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/collectionGroups/*}/fields',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListIndexes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/databases/*/collectionGroups/*}/indexes',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDatabase' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{database.name=projects/*/databases/*}',
                'body' => 'database',
                'placeholders' => [
                    'database.name' => [
                        'getters' => [
                            'getDatabase',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateField' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{field.name=projects/*/databases/*/collectionGroups/*/fields/*}',
                'body' => 'field',
                'placeholders' => [
                    'field.name' => [
                        'getters' => [
                            'getField',
                            'getName',
                        ],
                    ],
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
