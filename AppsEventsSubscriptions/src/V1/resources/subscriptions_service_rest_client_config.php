<?php

return [
    'interfaces' => [
        'google.apps.events.subscriptions.v1.SubscriptionsService' => [
            'CreateSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v1/subscriptions',
                'body' => 'subscription',
            ],
            'DeleteSubscription' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=subscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSubscription' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=subscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/subscriptions',
                'queryParams' => [
                    'filter',
                ],
            ],
            'ReactivateSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=subscriptions/*}:reactivate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSubscription' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{subscription.name=subscriptions/*}',
                'body' => 'subscription',
                'placeholders' => [
                    'subscription.name' => [
                        'getters' => [
                            'getSubscription',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
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
        ],
    ],
    'numericEnums' => true,
];
