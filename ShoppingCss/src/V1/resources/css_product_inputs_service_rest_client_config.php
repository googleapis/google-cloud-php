<?php

return [
    'interfaces' => [
        'google.shopping.css.v1.CssProductInputsService' => [
            'DeleteCssProductInput' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=accounts/*/cssProductInputs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InsertCssProductInput' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}/cssProductInputs:insert',
                'body' => 'css_product_input',
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
