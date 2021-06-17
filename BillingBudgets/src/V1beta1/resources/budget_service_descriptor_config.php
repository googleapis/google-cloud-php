<?php

return [
    'interfaces' => [
        'google.cloud.billing.budgets.v1beta1.BudgetService' => [
            'ListBudgets' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getBudgets',
                ],
            ],
        ],
    ],
];
