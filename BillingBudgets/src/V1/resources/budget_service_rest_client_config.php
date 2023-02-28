<?php

return [
    'interfaces' => [
        'google.cloud.billing.budgets.v1.BudgetService' => [
            'CreateBudget' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=billingAccounts/*}/budgets',
                'body' => 'budget',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteBudget' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=billingAccounts/*/budgets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetBudget' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=billingAccounts/*/budgets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBudgets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=billingAccounts/*}/budgets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateBudget' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{budget.name=billingAccounts/*/budgets/*}',
                'body' => 'budget',
                'placeholders' => [
                    'budget.name' => [
                        'getters' => [
                            'getBudget',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
