<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Documents' => [
            'CreateDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/knowledgeBases/*}/documents',
                'body' => 'document',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/knowledgeBases/*}/documents',
                        'body' => 'document',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/knowledgeBases/*}/documents',
                        'body' => 'document',
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
            'DeleteDocument' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=projects/*/agent/knowledgeBases/*/documents/*}',
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
            'ExportDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}:export',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}:export',
                        'body' => '*',
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
            'GetDocument' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/agent/knowledgeBases/*/documents/*}',
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
            'ImportDocuments' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/knowledgeBases/*}/documents:import',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/knowledgeBases/*}/documents:import',
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
                'uriTemplate' => '/v2/{parent=projects/*/knowledgeBases/*}/documents',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/locations/*/knowledgeBases/*}/documents',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=projects/*/agent/knowledgeBases/*}/documents',
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
            'ReloadDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/knowledgeBases/*/documents/*}:reload',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/knowledgeBases/*/documents/*}:reload',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=projects/*/agent/knowledgeBases/*/documents/*}:reload',
                        'body' => '*',
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
            'UpdateDocument' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{document.name=projects/*/knowledgeBases/*/documents/*}',
                'body' => 'document',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{document.name=projects/*/locations/*/knowledgeBases/*/documents/*}',
                        'body' => 'document',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{document.name=projects/*/agent/knowledgeBases/*/documents/*}',
                        'body' => 'document',
                    ],
                ],
                'placeholders' => [
                    'document.name' => [
                        'getters' => [
                            'getDocument',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
