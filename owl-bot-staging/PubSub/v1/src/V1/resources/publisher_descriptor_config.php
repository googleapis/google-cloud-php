<?php

return [
    'interfaces' => [
        'google.pubsub.v1.Publisher' => [
            'CreateTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Topic',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Protobuf\GPBEmpty',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'DetachSubscription' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\DetachSubscriptionResponse',
                'headerParams' => [
                    [
                        'keyName' => 'subscription',
                        'fieldAccessors' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'GetTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Topic',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopicSnapshots' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSnapshots',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\ListTopicSnapshotsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopicSubscriptions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSubscriptions',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\ListTopicSubscriptionsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopics' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTopics',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\ListTopicsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'project',
                        'fieldAccessors' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'Publish' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\PublishResponse',
                'headerParams' => [
                    [
                        'keyName' => 'topic',
                        'fieldAccessors' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'UpdateTopic' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\PubSub\V1\Topic',
                'headerParams' => [
                    [
                        'keyName' => 'topic.name',
                        'fieldAccessors' => [
                            'getTopic',
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
                'schema' => 'projects/{project}/schemas/{schema}',
                'subscription' => 'projects/{project}/subscriptions/{subscription}',
                'topic' => 'projects/{project}/topics/{topic}',
            ],
        ],
    ],
];
