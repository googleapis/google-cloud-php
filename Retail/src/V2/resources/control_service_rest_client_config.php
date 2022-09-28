<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.ControlService' => [
            'CreateControl' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*}/controls',
                'body' => 'control',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'control_id',
                ],
            ],
            'DeleteControl' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/controls/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetControl' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/controls/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListControls' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*}/controls',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateControl' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{control.name=projects/*/locations/*/catalogs/*/controls/*}',
                'body' => 'control',
                'placeholders' => [
                    'control.name' => [
                        'getters' => [
                            'getControl',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/branches/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/operations/*}',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*}/operations',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*}/operations',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=projects/*}/operations',
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
        ],
    ],
];
