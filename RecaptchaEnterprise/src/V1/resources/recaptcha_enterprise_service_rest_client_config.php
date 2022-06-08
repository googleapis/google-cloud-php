<?php

return [
    'interfaces' => [
        'google.cloud.recaptchaenterprise.v1.RecaptchaEnterpriseService' => [
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
            'GetMetrics' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/keys/*/metrics}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
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
            'ListRelatedAccountGroupMemberships' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/relatedaccountgroups/*}/memberships',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRelatedAccountGroups' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/relatedaccountgroups',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'MigrateKey' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/keys/*}:migrate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SearchRelatedAccountGroupMemberships' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/relatedaccountgroupmemberships:search',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
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
        ],
    ],
];
