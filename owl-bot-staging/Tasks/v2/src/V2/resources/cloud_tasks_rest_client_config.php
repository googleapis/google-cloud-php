<?php

return [
    'interfaces' => [
        'google.cloud.tasks.v2.CloudTasks' => [
            'CreateQueue' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/queues',
                'body' => 'queue',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreateTask' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/queues/*}/tasks',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteQueue' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTask' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*/tasks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/queues/*}:getIamPolicy',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'GetQueue' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTask' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*/tasks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListQueues' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*}/queues',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTasks' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*/locations/*/queues/*}/tasks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PauseQueue' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*}:pause',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'PurgeQueue' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*}:purge',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumeQueue' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'RunTask' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/locations/*/queues/*/tasks/*}:run',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/queues/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v2/{resource=projects/*/locations/*/queues/*}:testIamPermissions',
                'body' => '*',
                'placeholders' => [
                    'resource' => [
                        'getters' => [
                            'getResource',
                        ],
                    ],
                ],
            ],
            'UpdateQueue' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{queue.name=projects/*/locations/*/queues/*}',
                'body' => 'queue',
                'placeholders' => [
                    'queue.name' => [
                        'getters' => [
                            'getQueue',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
