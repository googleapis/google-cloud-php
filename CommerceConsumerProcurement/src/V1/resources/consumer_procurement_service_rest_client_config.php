<?php

return [
    'interfaces' => [
        'google.cloud.commerce.consumer.procurement.v1.ConsumerProcurementService' => [
            'GetOrder' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=billingAccounts/*/orders/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOrders' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=billingAccounts/*}/orders',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PlaceOrder' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=billingAccounts/*}/orders:place',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=billingAccounts/*/orders/*/operations/*}',
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
