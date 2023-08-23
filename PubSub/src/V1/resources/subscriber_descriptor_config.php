<?php

return [
    'interfaces' => [
        'google.pubsub.v1.Subscriber' => [
            'Acknowledge' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'CreateSnapshot' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Snapshot',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateSubscription' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Subscription',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSnapshot' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'snapshot',
                        'fieldAccessors' => [
                            'getSnapshot',
                        ],
                    ],
                ],
            ],
            'DeleteSubscription' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'GetSnapshot' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Snapshot',
                'headerParams' => [
                    [
                        'keyName' => 'snapshot',
                        'fieldAccessors' => [
                            'getSnapshot',
                        ],
                    ],
                ],
            ],
            'GetSubscription' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Subscription',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'ListSnapshots' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSnapshots',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\ListSnapshotsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
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
                'responseType' => 'Google\Cloud\PubSub\V1\ListSubscriptionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ModifyAckDeadline' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'ModifyPushConfig' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'Pull' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\PullResponse',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'Seek' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\SeekResponse',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'StreamingPull' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\StreamingPullResponse',
            ],
            'UpdateSnapshot' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Snapshot',
                'headerParams' => [
                    [
                        'keyName' => 'snapshot.name',
                        'fieldAccessors' => [
                            'getSnapshot',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSubscription' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Subscription',
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
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
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
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
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
                'interfaceOverride' => 'google.iam.v1.IAMPolicy',
            ],
            'templateMap' => [
                'deletedTopic' => '_deleted-topic_',
                'project' => 'projects/{project}',
                'projectTopic' => 'projects/{project}/topics/{topic}',
                'snapshot' => 'projects/{project}/snapshots/{snapshot}',
                'subscription' => 'projects/{project}/subscriptions/{subscription}',
                'topic' => 'projects/{project}/topics/{topic}',
            ],
        ],
    ],
];
