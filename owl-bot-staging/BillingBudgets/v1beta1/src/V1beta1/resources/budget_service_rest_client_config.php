<?php

return [
    'interfaces' => [
        'google.cloud.billing.budgets.v1beta1.BudgetService' => [
            'CreateBudget' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/{parent=billingAccounts/*}/budgets',
                'body' => '*',
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
                'uriTemplate' => '/v1beta1/{name=billingAccounts/*/budgets/*}',
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
                'uriTemplate' => '/v1beta1/{name=billingAccounts/*/budgets/*}',
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
                'uriTemplate' => '/v1beta1/{parent=billingAccounts/*}/budgets',
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
                'uriTemplate' => '/v1beta1/{budget.name=billingAccounts/*/budgets/*}',
                'body' => '*',
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
