<?php

return [
    'interfaces' => [
        'google.cloud.bigquery.connection.v1.ConnectionService' => [
            'CreateConnection' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connections',
                'body' => 'connection',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteConnection' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConnection' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connections/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/connections/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'ListConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/connections',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'page_size',
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/connections/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/connections/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateConnection' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/connections/*}',
                'body' => 'connection',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
];
