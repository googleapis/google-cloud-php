<?php

return [
    'interfaces' => [
        'google.cloud.billing.v1.CloudCatalog' => [
            'ListServices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/services',
            ],
            'ListSkus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=services/*}/skus',
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
];
