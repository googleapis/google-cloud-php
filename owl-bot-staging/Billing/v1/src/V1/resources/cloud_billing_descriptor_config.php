<?php

return [
    'interfaces' => [
        'google.cloud.billing.v1.CloudBilling' => [
            'CreateBillingAccount' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Billing\V1\BillingAccount',
            ],
            'GetBillingAccount' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Billing\V1\BillingAccount',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetProjectBillingInfo' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Billing\V1\ProjectBillingInfo',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListBillingAccounts' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getBillingAccounts',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Billing\V1\ListBillingAccountsResponse',
            ],
            'ListProjectBillingInfo' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getProjectBillingInfo',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\Billing\V1\ListProjectBillingInfoResponse',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\Policy',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Iam\V1\TestIamPermissionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'resource',
                        'fieldAccessors' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateBillingAccount' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Billing\V1\BillingAccount',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateProjectBillingInfo' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Billing\V1\ProjectBillingInfo',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'billingAccount' => 'billingAccounts/{billing_account}',
                'projectBillingInfo' => 'projects/{project}/billingInfo',
            ],
        ],
    ],
];
