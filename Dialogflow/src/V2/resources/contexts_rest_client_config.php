<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Contexts' => [
            'ListContexts' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/contexts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetContext' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/agent/sessions/*/contexts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateContext' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/contexts',
                'body' => 'context',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateContext' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{context.name=projects/*/agent/sessions/*/contexts/*}',
                'body' => 'context',
                'placeholders' => [
                    'context.name' => [
                        'getters' => [
                            'getContext',
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteContext' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/agent/sessions/*/contexts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteAllContexts' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{parent=projects/*/agent/sessions/*}/contexts',
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
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/operations/*}',
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
