<?php

return [
    'interfaces' => [
        'google.cloud.kms.inventory.v1.KeyDashboardService' => [
            'ListCryptoKeys' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/cryptoKeys',
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
