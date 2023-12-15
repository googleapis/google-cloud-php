<?php

return [
    'interfaces' => [
        'google.shopping.merchant.inventories.v1beta.LocalInventoryService' => [
            'DeleteLocalInventory' => [
                'method' => 'delete',
                'uriTemplate' => '/inventories/v1beta/{name=accounts/*/products/*/localInventories/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InsertLocalInventory' => [
                'method' => 'post',
                'uriTemplate' => '/inventories/v1beta/{parent=accounts/*/products/*}/localInventories:insert',
                'body' => 'local_inventory',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListLocalInventories' => [
                'method' => 'get',
                'uriTemplate' => '/inventories/v1beta/{parent=accounts/*/products/*}/localInventories',
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
