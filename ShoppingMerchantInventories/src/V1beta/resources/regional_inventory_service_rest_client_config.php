<?php

return [
    'interfaces' => [
        'google.shopping.merchant.inventories.v1beta.RegionalInventoryService' => [
            'DeleteRegionalInventory' => [
                'method' => 'delete',
                'uriTemplate' => '/inventories/v1beta/{name=accounts/*/products/*/regionalInventories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InsertRegionalInventory' => [
                'method' => 'post',
                'uriTemplate' => '/inventories/v1beta/{parent=accounts/*/products/*}/regionalInventories:insert',
                'body' => 'regional_inventory',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRegionalInventories' => [
                'method' => 'get',
                'uriTemplate' => '/inventories/v1beta/{parent=accounts/*/products/*}/regionalInventories',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
