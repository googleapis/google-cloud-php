<?php

return [
    'interfaces' => [
        'google.pubsub.v1.Subscriber' => [
            'CreateSubscription' => [
                'method' => 'put',
                'uri' => '/v1/{name=projects/*/subscriptions/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'GetSubscription' => [
                'method' => 'get',
                'uri' => '/v1/{subscription=projects/*/subscriptions/*}',
                'placeholders' => [
                    'subscription' => [
                        'getSubscription',
                    ],
                ],
            ],
            'UpdateSubscription' => [
                'method' => 'patch',
                'uri' => '/v1/{subscription.name=projects/*/subscriptions/*}',
                'body' => '*',
                'placeholders' => [
                    'subscription.name' => [
                        'getSubscription',
                        'getName',
                    ],
                ],
            ],
            'ListSubscriptions' => [
                'method' => 'get',
                'uri' => '/v1/{project=projects/*}/subscriptions',
                'placeholders' => [
                    'project' => [
                        'getProject',
                    ],
                ],
            ],
            'DeleteSubscription' => [
                'method' => 'delete',
                'uri' => '/v1/{subscription=projects/*/subscriptions/*}',
                'placeholders' => [
                    'subscription' => [
                        'getSubscription',
                    ],
                ],
            ],
            'ModifyAckDeadline' => [
                'method' => 'post',
                'uri' => '/v1/{subscription=projects/*/subscriptions/*}:modifyAckDeadline',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getSubscription',
                    ],
                ],
            ],
            'Acknowledge' => [
                'method' => 'post',
                'uri' => '/v1/{subscription=projects/*/subscriptions/*}:acknowledge',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getSubscription',
                    ],
                ],
            ],
            'Pull' => [
                'method' => 'post',
                'uri' => '/v1/{subscription=projects/*/subscriptions/*}:pull',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getSubscription',
                    ],
                ],
            ],
            'ModifyPushConfig' => [
                'method' => 'post',
                'uri' => '/v1/{subscription=projects/*/subscriptions/*}:modifyPushConfig',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getSubscription',
                    ],
                ],
            ],
            'ListSnapshots' => [
                'method' => 'get',
                'uri' => '/v1/{project=projects/*}/snapshots',
                'placeholders' => [
                    'project' => [
                        'getProject',
                    ],
                ],
            ],
            'CreateSnapshot' => [
                'method' => 'put',
                'uri' => '/v1/{name=projects/*/snapshots/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getName',
                    ],
                ],
            ],
            'UpdateSnapshot' => [
                'method' => 'patch',
                'uri' => '/v1/{snapshot.name=projects/*/snapshots/*}',
                'body' => '*',
                'placeholders' => [
                    'snapshot.name' => [
                        'getSnapshot',
                        'getName',
                    ],
                ],
            ],
            'DeleteSnapshot' => [
                'method' => 'delete',
                'uri' => '/v1/{snapshot=projects/*/snapshots/*}',
                'placeholders' => [
                    'snapshot' => [
                        'getSnapshot',
                    ],
                ],
            ],
            'Seek' => [
                'method' => 'post',
                'uri' => '/v1/{subscription=projects/*/subscriptions/*}:seek',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getSubscription',
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
