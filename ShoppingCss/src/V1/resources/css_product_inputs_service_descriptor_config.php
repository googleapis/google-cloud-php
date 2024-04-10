<?php

return [
    'interfaces' => [
        'google.shopping.css.v1.CssProductInputsService' => [
            'DeleteCssProductInput' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InsertCssProductInput' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Shopping\Css\V1\CssProductInput',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'account' => 'accounts/{account}',
                'cssProductInput' => 'accounts/{account}/cssProductInputs/{css_product_input}',
            ],
        ],
    ],
];
