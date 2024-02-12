<?php

return [
    'interfaces' => [
        'google.shopping.css.v1.AccountsService' => [
            'GetAccount' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accounts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListChildAccounts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*}:listChildAccounts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateLabels' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*}:updateLabels',
                'body' => '*',
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
    'numericEnums' => true,
];
