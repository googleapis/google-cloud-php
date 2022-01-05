<?php

return [
    'interfaces' => [
        'google.cloud.apigateway.v1.ApiGatewayService' => [
            'CreateApi' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apis',
                'body' => 'api',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'api_id',
                ],
            ],
            'CreateApiConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/configs',
                'body' => 'api_config',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'api_config_id',
                ],
            ],
            'CreateGateway' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/gateways',
                'body' => 'gateway',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'gateway_id',
                ],
            ],
            'DeleteApi' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteApiConfig' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/configs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteGateway' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gateways/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApi' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetApiConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/apis/*/configs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetGateway' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/gateways/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListApiConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/apis/*}/configs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListApis' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/apis',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListGateways' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/gateways',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateApi' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{api.name=projects/*/locations/*/apis/*}',
                'body' => 'api',
                'placeholders' => [
                    'api.name' => [
                        'getters' => [
                            'getApi',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateApiConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{api_config.name=projects/*/locations/*/apis/*/configs/*}',
                'body' => 'api_config',
                'placeholders' => [
                    'api_config.name' => [
                        'getters' => [
                            'getApiConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateGateway' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{gateway.name=projects/*/locations/*/gateways/*}',
                'body' => 'gateway',
                'placeholders' => [
                    'gateway.name' => [
                        'getters' => [
                            'getGateway',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
