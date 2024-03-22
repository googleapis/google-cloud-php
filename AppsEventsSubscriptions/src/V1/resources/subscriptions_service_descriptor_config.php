<?php

return [
    'interfaces' => [
        'google.apps.events.subscriptions.v1.SubscriptionsService' => [
            'CreateSubscription' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Apps\Events\Subscriptions\V1\Subscription',
                    'metadataReturnType' => '\Google\Apps\Events\Subscriptions\V1\CreateSubscriptionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
            ],
            'DeleteSubscription' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Protobuf\GPBEmpty',
                    'metadataReturnType' => '\Google\Apps\Events\Subscriptions\V1\DeleteSubscriptionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ReactivateSubscription' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Apps\Events\Subscriptions\V1\Subscription',
                    'metadataReturnType' => '\Google\Apps\Events\Subscriptions\V1\ReactivateSubscriptionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSubscription' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Apps\Events\Subscriptions\V1\Subscription',
                    'metadataReturnType' => '\Google\Apps\Events\Subscriptions\V1\UpdateSubscriptionMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
                'callType' => \Google\ApiCore\Call::LONGRUNNING_CALL,
                'headerParams' => [
                    [
                        'keyName' => 'subscription.name',
                        'fieldAccessors' => [
                            'getSubscription',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSubscription' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Apps\Events\Subscriptions\V1\Subscription',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSubscriptions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSubscriptions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Apps\Events\Subscriptions\V1\ListSubscriptionsResponse',
            ],
            'templateMap' => [
                'subscription' => 'subscriptions/{subscription}',
                'topic' => 'projects/{project}/topics/{topic}',
                'user' => 'users/{user}',
            ],
        ],
    ],
];
