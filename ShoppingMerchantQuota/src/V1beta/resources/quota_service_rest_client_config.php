<?php

return [
    'interfaces' => [
        'google.shopping.merchant.quota.v1beta.QuotaService' => [
            'ListQuotaGroups' => [
                'method' => 'get',
                'uriTemplate' => '/quota/v1beta/{parent=accounts/*}/quotas',
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
