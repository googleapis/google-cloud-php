<?php

return [
    'interfaces' => [
        'google.cloud.orgpolicy.v2.OrgPolicy' => [
            'CreatePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/policies',
                'body' => 'policy',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*}/policies',
                        'body' => 'policy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*}/policies',
                        'body' => 'policy',
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
            'DeletePolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/policies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=folders/*/policies/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=organizations/*/policies/*}',
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
            'GetEffectivePolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/policies/*}:getEffectivePolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/policies/*}:getEffectivePolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/policies/*}:getEffectivePolicy',
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
            'GetPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/policies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/policies/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/policies/*}',
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
            'ListConstraints' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/constraints',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*}/constraints',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/constraints',
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
            'ListPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/policies',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*}/policies',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/policies',
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
            'UpdatePolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{policy.name=projects/*/policies/*}',
                'body' => 'policy',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{policy.name=folders/*/policies/*}',
                        'body' => 'policy',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{policy.name=organizations/*/policies/*}',
                        'body' => 'policy',
                    ],
                ],
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
    ],
];
