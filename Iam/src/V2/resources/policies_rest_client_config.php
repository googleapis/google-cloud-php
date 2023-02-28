<?php

return [
    'interfaces' => [
        'google.iam.v2.Policies' => [
            'CreatePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=policies/*/*}',
                'body' => 'policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeletePolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=policies/*/*/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=policies/*/*/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=policies/*/*}',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdatePolicy' => [
                'method' => 'put',
                'uriTemplate' => '/v2/{policy.name=policies/*/*/*}',
                'body' => 'policy',
                'placeholders' => [
                    'policy.name' => [
                        'getters' => [
                            'getPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=policies/*/*/*/operations/*}',
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
