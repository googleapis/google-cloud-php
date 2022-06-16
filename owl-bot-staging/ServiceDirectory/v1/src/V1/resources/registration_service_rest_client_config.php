<?php

return [
    'interfaces' => [
        'google.cloud.servicedirectory.v1.RegistrationService' => [
            'CreateEndpoint' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/namespaces/*/services/*}/endpoints',
                'body' => 'endpoint',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'endpoint_id',
                ],
            ],
            'CreateNamespace' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/namespaces',
                'body' => 'namespace',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'namespace_id',
                ],
            ],
            'CreateService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/namespaces/*}/services',
                'body' => 'service',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'service_id',
                ],
            ],
            'DeleteEndpoint' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/namespaces/*/services/*/endpoints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteNamespace' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/namespaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteService' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/namespaces/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEndpoint' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/namespaces/*/services/*/endpoints/*}',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/namespaces/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/namespaces/*/services/*}:getIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetNamespace' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/namespaces/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetService' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/namespaces/*/services/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListEndpoints' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/namespaces/*/services/*}/endpoints',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListNamespaces' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/namespaces',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListServices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/namespaces/*}/services',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/namespaces/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/namespaces/*/services/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/namespaces/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/namespaces/*/services/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateEndpoint' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{endpoint.name=projects/*/locations/*/namespaces/*/services/*/endpoints/*}',
                'body' => 'endpoint',
                'placeholders' => [
                    'endpoint.name' => [
                        'getters' => [
                            'getEndpoint',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateNamespace' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{namespace.name=projects/*/locations/*/namespaces/*}',
                'body' => 'namespace',
                'placeholders' => [
                    'namespace.name' => [
                        'getters' => [
                            'getNamespace',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateService' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{service.name=projects/*/locations/*/namespaces/*/services/*}',
                'body' => 'service',
                'placeholders' => [
                    'service.name' => [
                        'getters' => [
                            'getService',
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
