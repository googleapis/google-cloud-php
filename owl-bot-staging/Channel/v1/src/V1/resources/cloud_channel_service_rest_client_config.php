<?php

return [
    'interfaces' => [
        'google.cloud.channel.v1.CloudChannelService' => [
            'ActivateEntitlement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}:activate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelEntitlement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ChangeOffer' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}:changeOffer',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ChangeParameters' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}:changeParameters',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ChangeRenewalSettings' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}:changeRenewalSettings',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CheckCloudIdentityAccountsExist' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}:checkCloudIdentityAccountsExist',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateChannelPartnerLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}/channelPartnerLinks',
                'body' => 'channel_partner_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateCustomer' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}/customers',
                'body' => 'customer',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=accounts/*/channelPartnerLinks/*}/customers',
                        'body' => 'customer',
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
            'CreateEntitlement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*/customers/*}/entitlements',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCustomer' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=accounts/*/channelPartnerLinks/*/customers/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetChannelPartnerLink' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accounts/*/channelPartnerLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomer' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=accounts/*/channelPartnerLinks/*/customers/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEntitlement' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportCustomer' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}/customers:import',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=accounts/*/channelPartnerLinks/*}/customers:import',
                        'body' => '*',
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
            'ListChannelPartnerLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*}/channelPartnerLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCustomers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*}/customers',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=accounts/*/channelPartnerLinks/*}/customers',
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
            'ListEntitlements' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*/customers/*}/entitlements',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListOffers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accounts/*}/offers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListProducts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/products',
                'queryParams' => [
                    'account',
                ],
            ],
            'ListPurchasableOffers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{customer=accounts/*/customers/*}:listPurchasableOffers',
                'placeholders' => [
                    'customer' => [
                        'getters' => [
                            'getCustomer',
                        ],
                    ],
                ],
            ],
            'ListPurchasableSkus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{customer=accounts/*/customers/*}:listPurchasableSkus',
                'placeholders' => [
                    'customer' => [
                        'getters' => [
                            'getCustomer',
                        ],
                    ],
                ],
            ],
            'ListSkus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=products/*}/skus',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'account',
                ],
            ],
            'ListSubscribers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{account=accounts/*}:listSubscribers',
                'placeholders' => [
                    'account' => [
                        'getters' => [
                            'getAccount',
                        ],
                    ],
                ],
            ],
            'ListTransferableOffers' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}:listTransferableOffers',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTransferableSkus' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*}:listTransferableSkus',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LookupOffer' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{entitlement=accounts/*/customers/*/entitlements/*}:lookupOffer',
                'placeholders' => [
                    'entitlement' => [
                        'getters' => [
                            'getEntitlement',
                        ],
                    ],
                ],
            ],
            'ProvisionCloudIdentity' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{customer=accounts/*/customers/*}:provisionCloudIdentity',
                'body' => '*',
                'placeholders' => [
                    'customer' => [
                        'getters' => [
                            'getCustomer',
                        ],
                    ],
                ],
            ],
            'RegisterSubscriber' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{account=accounts/*}:register',
                'body' => '*',
                'placeholders' => [
                    'account' => [
                        'getters' => [
                            'getAccount',
                        ],
                    ],
                ],
            ],
            'StartPaidService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}:startPaidService',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SuspendEntitlement' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=accounts/*/customers/*/entitlements/*}:suspend',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'TransferEntitlements' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*/customers/*}:transferEntitlements',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'TransferEntitlementsToGoogle' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accounts/*/customers/*}:transferEntitlementsToGoogle',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UnregisterSubscriber' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{account=accounts/*}:unregister',
                'body' => '*',
                'placeholders' => [
                    'account' => [
                        'getters' => [
                            'getAccount',
                        ],
                    ],
                ],
            ],
            'UpdateChannelPartnerLink' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{name=accounts/*/channelPartnerLinks/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCustomer' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{customer.name=accounts/*/customers/*}',
                'body' => 'customer',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v1/{customer.name=accounts/*/channelPartnerLinks/*/customers/*}',
                        'body' => 'customer',
                    ],
                ],
                'placeholders' => [
                    'customer.name' => [
                        'getters' => [
                            'getCustomer',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=operations/**}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteOperation' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=operations/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=operations/**}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=operations}',
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
];
