<?php

return [
    'interfaces' => [
        'google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService' => [
            'CreateAssessment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/assessments',
                'body' => 'assessment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'AnnotateAssessment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/assessments/*}:annotate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/keys',
                'body' => 'key',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/keys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetKey' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateKey' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{key.name=projects/*/keys/*}',
                'body' => 'key',
                'placeholders' => [
                    'key.name' => [
                        'getters' => [
                            'getKey',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteKey' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}',
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
