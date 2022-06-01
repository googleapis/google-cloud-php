<?php

return [
    'interfaces' => [
        'google.cloud.retail.v2.ProductService' => [
            'AddFulfillmentPlaces' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{product=projects/*/locations/*/catalogs/*/branches/*/products/**}:addFulfillmentPlaces',
                'body' => '*',
                'placeholders' => [
                    'product' => [
                        'getters' => [
                            'getProduct',
                        ],
                    ],
                ],
            ],
            'AddLocalInventories' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{product=projects/*/locations/*/catalogs/*/branches/*/products/**}:addLocalInventories',
                'body' => '*',
                'placeholders' => [
                    'product' => [
                        'getters' => [
                            'getProduct',
                        ],
                    ],
                ],
            ],
            'CreateProduct' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*/branches/*}/products',
                'body' => 'product',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'product_id',
                ],
            ],
            'DeleteProduct' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/branches/*/products/**}',
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
                'uriTemplate' => '/v2/{name=projects/*/locations/*/catalogs/*/branches/*/products/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportProducts' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*/branches/*}/products:import',
                'body' => '*',
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
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/catalogs/*/branches/*}/products',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RemoveFulfillmentPlaces' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{product=projects/*/locations/*/catalogs/*/branches/*/products/**}:removeFulfillmentPlaces',
                'body' => '*',
                'placeholders' => [
                    'product' => [
                        'getters' => [
                            'getProduct',
                        ],
                    ],
                ],
            ],
            'RemoveLocalInventories' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{product=projects/*/locations/*/catalogs/*/branches/*/products/**}:removeLocalInventories',
                'body' => '*',
                'placeholders' => [
                    'product' => [
                        'getters' => [
                            'getProduct',
                        ],
                    ],
                ],
            ],
            'SetInventory' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{inventory.name=projects/*/locations/*/catalogs/*/branches/*/products/**}:setInventory',
                'body' => '*',
                'placeholders' => [
                    'inventory.name' => [
                        'getters' => [
                            'getInventory',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProduct' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{product.name=projects/*/locations/*/catalogs/*/branches/*/products/**}',
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
