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
        'google.cloud.billing.v1.CloudBilling' => [
            'CreateBillingAccount' => [
                'method' => 'post',
                'uriTemplate' => '/v1/billingAccounts',
                'body' => 'billing_account',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=organizations/*}/billingAccounts',
                        'body' => 'billing_account',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=billingAccounts/*}/subAccounts',
                        'body' => 'billing_account',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetBillingAccount' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=billingAccounts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=billingAccounts/*}:getIamPolicy',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetProjectBillingInfo' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/billingInfo',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBillingAccounts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/billingAccounts',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=organizations/*}/billingAccounts',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=billingAccounts/*}/subAccounts',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProjectBillingInfo' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=billingAccounts/*}/projects',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'MoveBillingAccount' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=billingAccounts/*}:move',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{destination_parent=organizations/*}/{name=billingAccounts/*}:move',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'destination_parent' => [
                        'getters' => [
                            'getDestinationParent',
                        ],
                    ],
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=billingAccounts/*}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=billingAccounts/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateBillingAccount' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=billingAccounts/*}',
                'body' => 'account',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProjectBillingInfo' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*}/billingInfo',
                'body' => 'project_billing_info',
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
