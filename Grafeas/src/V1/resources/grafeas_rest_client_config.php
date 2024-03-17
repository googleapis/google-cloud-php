<?php

return [
    'interfaces' => [
        'grafeas.v1.Grafeas' => [
            'BatchCreateNotes' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/notes:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchCreateOccurrences' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/occurrences:batchCreate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateNote' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/notes',
                'body' => 'note',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'note_id',
                ],
            ],
            'CreateOccurrence' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/occurrences',
                'body' => 'occurrence',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteNote' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/notes/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOccurrence' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/occurrences/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNote' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/notes/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notes/*}',
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
            'GetOccurrence' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/occurrences/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/occurrences/*}',
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
            'GetOccurrenceNote' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/occurrences/*}/notes',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/occurrences/*}/notes',
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
            'ListNoteOccurrences' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/notes/*}/occurrences',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/notes/*}/occurrences',
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
            'ListNotes' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/notes',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*}/notes',
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
            'ListOccurrences' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/occurrences',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/locations/*}/occurrences',
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
            'UpdateNote' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/notes/*}',
                'body' => 'note',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateOccurrence' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/occurrences/*}',
                'body' => 'occurrence',
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
    'numericEnums' => true,
];
