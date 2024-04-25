<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
    'numericEnums' => true,
];
