<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1p1beta1.Adaptation' => [
            'CreateCustomClass' => [
                'method' => 'post',
                'uriTemplate' => '/v1p1beta1/{parent=projects/*/locations/*}/customClasses',
                'body' => '*',
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
                'uriTemplate' => '/v1p1beta1/{parent=projects/*/locations/*}/phraseSets',
                'body' => '*',
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
                'uriTemplate' => '/v1p1beta1/{name=projects/*/locations/*/customClasses/*}',
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
                'uriTemplate' => '/v1p1beta1/{name=projects/*/locations/*/phraseSets/*}',
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
                'uriTemplate' => '/v1p1beta1/{name=projects/*/locations/*/customClasses/*}',
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
                'uriTemplate' => '/v1p1beta1/{name=projects/*/locations/*/phraseSets/*}',
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
                'uriTemplate' => '/v1p1beta1/{parent=projects/*/locations/*}/customClasses',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPhraseSet' => [
                'method' => 'get',
                'uriTemplate' => '/v1p1beta1/{parent=projects/*/locations/*}/phraseSets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCustomClass' => [
                'method' => 'patch',
                'uriTemplate' => '/v1p1beta1/{custom_class.name=projects/*/locations/*/customClasses/*}',
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
                'uriTemplate' => '/v1p1beta1/{phrase_set.name=projects/*/locations/*/phraseSets/*}',
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
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1p1beta1/operations/{name=**}',
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
                'uriTemplate' => '/v1p1beta1/operations',
            ],
        ],
    ],
];
