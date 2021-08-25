<?php

return [
    'interfaces' => [
        'google.iam.v1.IAMPolicy' => [
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
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/schemas/*}:getIamPolicy',
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
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/schemas/*}:setIamPolicy',
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
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/schemas/*}:testIamPermissions',
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
        'google.pubsub.v1.Subscriber' => [
            'Acknowledge' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}:acknowledge',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'CreateSnapshot' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/snapshots/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateSubscription' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{name=projects/*/subscriptions/*}',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteSnapshot' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{snapshot=projects/*/snapshots/*}',
                'placeholders' => [
                    'snapshot' => [
                        'getters' => [
                            'getSnapshot',
                        ],
                    ],
                ],
            ],
            'DeleteSubscription' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'GetSnapshot' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{snapshot=projects/*/snapshots/*}',
                'placeholders' => [
                    'snapshot' => [
                        'getters' => [
                            'getSnapshot',
                        ],
                    ],
                ],
            ],
            'GetSubscription' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'ListSnapshots' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{project=projects/*}/snapshots',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ListSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{project=projects/*}/subscriptions',
                'placeholders' => [
                    'project' => [
                        'getters' => [
                            'getProject',
                        ],
                    ],
                ],
            ],
            'ModifyAckDeadline' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}:modifyAckDeadline',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'ModifyPushConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}:modifyPushConfig',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'Pull' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}:pull',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'Seek' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{subscription=projects/*/subscriptions/*}:seek',
                'body' => '*',
                'placeholders' => [
                    'subscription' => [
                        'getters' => [
                            'getSubscription',
                        ],
                    ],
                ],
            ],
            'UpdateSnapshot' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{snapshot.name=projects/*/snapshots/*}',
                'body' => '*',
                'placeholders' => [
                    'snapshot.name' => [
                        'getters' => [
                            'getSnapshot',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSubscription' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{subscription.name=projects/*/subscriptions/*}',
                'body' => '*',
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
    ],
];
