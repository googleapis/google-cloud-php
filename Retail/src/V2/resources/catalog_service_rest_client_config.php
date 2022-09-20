<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.CatalogService' => [
            'AddCatalogAttribute' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{attributes_config=projects/*/locations/*/catalogs/*/attributesConfig}:addCatalogAttribute',
                'body' => '*',
                'placeholders' => [
                    'attributes_config' => [
                        'getters' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'GetAttributesConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/attributesConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCompletionConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/completionConfig}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDefaultBranch' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{catalog=projects/*/locations/*/catalogs/*}:getDefaultBranch',
                'placeholders' => [
                    'catalog' => [
                        'getters' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'ListCatalogs' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/catalogs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveCatalogAttribute' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{attributes_config=projects/*/locations/*/catalogs/*/attributesConfig}:removeCatalogAttribute',
                'body' => '*',
                'placeholders' => [
                    'attributes_config' => [
                        'getters' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'ReplaceCatalogAttribute' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{attributes_config=projects/*/locations/*/catalogs/*/attributesConfig}:replaceCatalogAttribute',
                'body' => '*',
                'placeholders' => [
                    'attributes_config' => [
                        'getters' => [
                            'getAttributesConfig',
                        ],
                    ],
                ],
            ],
            'SetDefaultBranch' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{catalog=projects/*/locations/*/catalogs/*}:setDefaultBranch',
                'body' => '*',
                'placeholders' => [
                    'catalog' => [
                        'getters' => [
                            'getCatalog',
                        ],
                    ],
                ],
            ],
            'UpdateAttributesConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{attributes_config.name=projects/*/locations/*/catalogs/*/attributesConfig}',
                'body' => 'attributes_config',
                'placeholders' => [
                    'attributes_config.name' => [
                        'getters' => [
                            'getAttributesConfig',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCatalog' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{catalog.name=projects/*/locations/*/catalogs/*}',
                'body' => 'catalog',
                'placeholders' => [
                    'catalog.name' => [
                        'getters' => [
                            'getCatalog',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCompletionConfig' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{completion_config.name=projects/*/locations/*/catalogs/*/completionConfig}',
                'body' => 'completion_config',
                'placeholders' => [
                    'completion_config.name' => [
                        'getters' => [
                            'getCompletionConfig',
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
