<?php

return [
    'interfaces' => [
        'google.iam.v1.IAMPolicy' => [
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/topics/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/subscriptions/*}:setIamPolicy',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/snapshots/*}:setIamPolicy',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/topics/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/subscriptions/*}:getIamPolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/snapshots/*}:getIamPolicy',
                    ],
                ],
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
                'uriTemplate' => '/v1/{resource=projects/*/subscriptions/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/topics/*}:testIamPermissions',
                        'body' => '*',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/snapshots/*}:testIamPermissions',
                        'body' => '*',
                    ],
                ],
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
        ],
        'google.pubsub.v1.Publisher' => [
            'CreateTopic' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/topics/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateTopic' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{topic.name=projects/*/topics/*}',
                'body' => '*',
                'placeholders' => [
                    'topic.name' => [
                        'getters' => [
                            'getTopic',
                            'getName',
                        ],
                    ],
                ],
            ],
            'Publish' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}:publish',
                'body' => '*',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'GetTopic' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'ListTopics' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{project=projects/*}/topics',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListTopicSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}/subscriptions',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
            'DeleteTopic' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{topic=projects/*/topics/*}',
                'placeholders' => [
                    'topic' => [
                        'getters' => [
                            'getTopic',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
