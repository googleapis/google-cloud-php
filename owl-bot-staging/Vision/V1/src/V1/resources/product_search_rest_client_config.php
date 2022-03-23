<?php

return [
    'interfaces' => [
        'google.cloud.vision.v1.ProductSearch' => [
            'AddProductToProductSet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/productSets/*}:addProduct',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateProduct' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/products',
                'body' => 'product',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateProductSet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/productSets',
                'body' => 'product_set',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateReferenceImage' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/products/*}/referenceImages',
                'body' => 'reference_image',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteProduct' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/products/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteProductSet' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/productSets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteReferenceImage' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/products/*/referenceImages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProduct' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/products/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetProductSet' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/productSets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetReferenceImage' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/products/*/referenceImages/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportProductSets' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/productSets:import',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProductSets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/productSets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProducts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/products',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProductsInProductSet' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/productSets/*}/products',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListReferenceImages' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/products/*}/referenceImages',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PurgeProducts' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/products:purge',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveProductFromProductSet' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/productSets/*}:removeProduct',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProduct' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{product.name=projects/*/locations/*/products/*}',
                'body' => 'product',
                'placeholders' => [
                    'product.name' => [
                        'getters' => [
                            'getProduct',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProductSet' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{product_set.name=projects/*/locations/*/productSets/*}',
                'body' => 'product_set',
                'placeholders' => [
                    'product_set.name' => [
                        'getters' => [
                            'getProductSet',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=locations/*/operations/*}',
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
