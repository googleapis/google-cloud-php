<?php

return [
    'interfaces' => [
        'google.shopping.css.v1.CssProductsService' => [
            'GetCssProduct' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accounts/*/cssProducts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCssProducts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*}/cssProducts',
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
