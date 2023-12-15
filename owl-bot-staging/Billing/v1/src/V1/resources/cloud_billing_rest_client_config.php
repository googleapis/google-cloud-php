<?php

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
