<?php

return [
    'interfaces' => [
        'google.shopping.css.v1.AccountLabelsService' => [
            'CreateAccountLabel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}/labels',
                'body' => 'account_label',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAccountLabel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=accounts/*/labels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAccountLabels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*}/labels',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAccountLabel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{account_label.name=accounts/*/labels/*}',
                'body' => 'account_label',
                'placeholders' => [
                    'account_label.name' => [
                        'getters' => [
                            'getAccountLabel',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
