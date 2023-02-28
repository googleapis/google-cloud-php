<?php

return [
    'interfaces' => [
        'google.cloud.speech.v2.Speech' => [
            'BatchRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{recognizer=projects/*/locations/*/recognizers/*}:batchRecognize',
                'body' => '*',
                'placeholders' => [
                    'recognizer' => [
                        'getters' => [
                            'getRecognizer',
                        ],
                    ],
                ],
            ],
            'CreateCustomClass' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/customClasses',
                'body' => 'custom_class',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreatePhraseSet' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/phraseSets',
                'body' => 'phrase_set',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateRecognizer' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/recognizers',
                'body' => 'recognizer',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCustomClass' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/customClasses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePhraseSet' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/phraseSets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteRecognizer' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/recognizers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/config}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomClass' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/customClasses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPhraseSet' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/phraseSets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRecognizer' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/recognizers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCustomClasses' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/customClasses',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPhraseSets' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/phraseSets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRecognizers' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/recognizers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'Recognize' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{recognizer=projects/*/locations/*/recognizers/*}:recognize',
                'body' => '*',
                'placeholders' => [
                    'recognizer' => [
                        'getters' => [
                            'getRecognizer',
                        ],
                    ],
                ],
            ],
            'UndeleteCustomClass' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/customClasses/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UndeletePhraseSet' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/phraseSets/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UndeleteRecognizer' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/recognizers/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{config.name=projects/*/locations/*/config}',
                'body' => 'config',
                'placeholders' => [
                    'config.name' => [
                        'getters' => [
                            'getConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCustomClass' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{custom_class.name=projects/*/locations/*/customClasses/*}',
                'body' => 'custom_class',
                'placeholders' => [
                    'custom_class.name' => [
                        'getters' => [
                            'getCustomClass',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePhraseSet' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{phrase_set.name=projects/*/locations/*/phraseSets/*}',
                'body' => 'phrase_set',
                'placeholders' => [
                    'phrase_set.name' => [
                        'getters' => [
                            'getPhraseSet',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateRecognizer' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{recognizer.name=projects/*/locations/*/recognizers/*}',
                'body' => 'recognizer',
                'placeholders' => [
                    'recognizer.name' => [
                        'getters' => [
                            'getRecognizer',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
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
