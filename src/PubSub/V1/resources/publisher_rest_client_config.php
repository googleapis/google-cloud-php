<?php

return [
    'interfaces' => [
        'google.pubsub.v1.Publisher' => [
            'CreateTopic' => [
                'method' => 'put',
                'uri' => '/v1/{name=projects/*/topics/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'UpdateTopic' => [
                'method' => 'patch',
                'uri' => '/v1/{topic.name=projects/*/topics/*}',
                'body' => '*',
                'placeholders' => [
                    'topic.name' => [
                        'getTopic',
                        'getName',
                    ],
                ],
            ],
            'Publish' => [
                'method' => 'post',
                'uri' => '/v1/{topic=projects/*/topics/*}:publish',
                'body' => '*',
                'placeholders' => [
                    'topic' => [
                        'getTopic',
                    ],
                ],
            ],
            'GetTopic' => [
                'method' => 'get',
                'uri' => '/v1/{topic=projects/*/topics/*}',
                'placeholders' => [
                    'topic' => [
                        'getTopic',
                    ],
                ],
            ],
            'ListTopics' => [
                'method' => 'get',
                'uri' => '/v1/{project=projects/*}/topics',
                'placeholders' => [
                    'project' => [
                        'getProject',
                    ],
                ],
            ],
            'ListTopicSubscriptions' => [
                'method' => 'get',
                'uri' => '/v1/{topic=projects/*/topics/*}/subscriptions',
                'placeholders' => [
                    'topic' => [
                        'getTopic',
                    ],
                ],
            ],
            'DeleteTopic' => [
                'method' => 'delete',
                'uri' => '/v1/{topic=projects/*/topics/*}',
                'placeholders' => [
                    'topic' => [
                        'getTopic',
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v1/{resource=**}:setIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uri' => '/v1/{resource=**}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
            'TestIamPermissions' => [
                'method' => 'post',
                'uri' => '/v1/{resource=**}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getResource',
                    ],
                ],
            ],
        ],
    ],
];
