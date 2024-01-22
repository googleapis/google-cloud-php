<?php

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.translation.v3.TranslationService' => [
            'AdaptiveMtTranslate' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:adaptiveMtTranslate',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchTranslateDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:batchTranslateDocument',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'BatchTranslateText' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:batchTranslateText',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateAdaptiveMtDataset' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/adaptiveMtDatasets',
                'body' => 'adaptive_mt_dataset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateGlossary' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/glossaries',
                'body' => 'glossary',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAdaptiveMtDataset' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAdaptiveMtFile' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*/adaptiveMtFiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGlossary' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/glossaries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DetectLanguage' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:detectLanguage',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=projects/*}:detectLanguage',
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
            'GetAdaptiveMtDataset' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAdaptiveMtFile' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/adaptiveMtDatasets/*/adaptiveMtFiles/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGlossary' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/glossaries/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSupportedLanguages' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/supportedLanguages',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=projects/*}/supportedLanguages',
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
            'ImportAdaptiveMtFile' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*}:importAdaptiveMtFile',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAdaptiveMtDatasets' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/adaptiveMtDatasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAdaptiveMtFiles' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*}/adaptiveMtFiles',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListAdaptiveMtSentences' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*/adaptiveMtFiles/*}/adaptiveMtSentences',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=projects/*/locations/*/adaptiveMtDatasets/*}/adaptiveMtSentences',
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
            'ListGlossaries' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/glossaries',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'TranslateDocument' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:translateDocument',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'TranslateText' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}:translateText',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=projects/*}:translateText',
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
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v3/{name=projects/*/locations/*}/operations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'WaitOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}:wait',
                'body' => '*',
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
