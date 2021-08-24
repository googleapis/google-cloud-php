<?php

return [
    'interfaces' => [
        'google.cloud.location.Locations' => [
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.cloud.vpcaccess.v1.VpcAccessService' => [
            'CreateConnector' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connectors',
                'body' => 'connector',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'connector_id',
                ],
            ],
            'DeleteConnector' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connectors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConnector' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connectors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListConnectors' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connectors',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
