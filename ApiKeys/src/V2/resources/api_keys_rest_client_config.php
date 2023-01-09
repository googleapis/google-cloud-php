<?php

return [
    'interfaces' => [
        'google.api.apikeys.v2.ApiKeys' => [
            'CreateKey' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/keys',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/keys/*}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/keys/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetKeyString' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/keys/*}/keyString',
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
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/keys',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupKey' => [
                'method' => 'get',
                'uriTemplate' => '/v2/keys:lookupKey',
            ],
            'UndeleteKey' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/keys/*}:undelete',
                'body' => '*',
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
                'uriTemplate' => '/v2/{key.name=projects/*/locations/*/keys/*}',
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
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=operations/*}',
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
