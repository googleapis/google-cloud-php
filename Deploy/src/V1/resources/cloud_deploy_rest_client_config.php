<?php

return [
    'interfaces' => [
        'google.cloud.deploy.v1.CloudDeploy' => [
            'AbandonRelease' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*}:abandon',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ApproveRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}:approve',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateDeliveryPipeline' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deliveryPipelines',
                'body' => 'delivery_pipeline',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'delivery_pipeline_id',
                ],
            ],
            'CreateRelease' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*}/releases',
                'body' => 'release',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'release_id',
                ],
            ],
            'CreateRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*/releases/*}/rollouts',
                'body' => 'rollout',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'rollout_id',
                ],
            ],
            'CreateTarget' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/targets',
                'body' => 'target',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'target_id',
                ],
            ],
            'DeleteDeliveryPipeline' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteTarget' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/targets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/config}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeliveryPipeline' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetJobRun' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*/jobRuns/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRelease' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRollout' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetTarget' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/targets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDeliveryPipelines' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deliveryPipelines',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListJobRuns' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}/jobRuns',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListReleases' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*}/releases',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRollouts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deliveryPipelines/*/releases/*}/rollouts',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListTargets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/targets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'RetryJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{rollout=projects/*/locations/*/deliveryPipelines/*/releases/*/rollouts/*}:retryJob',
                'body' => '*',
                'placeholders' => [
                    'rollout' => [
                        'getters' => [
                            'getRollout',
                        ],
                    ],
                ],
            ],
            'UpdateDeliveryPipeline' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{delivery_pipeline.name=projects/*/locations/*/deliveryPipelines/*}',
                'body' => 'delivery_pipeline',
                'placeholders' => [
                    'delivery_pipeline.name' => [
                        'getters' => [
                            'getDeliveryPipeline',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
            'UpdateTarget' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{target.name=projects/*/locations/*/targets/*}',
                'body' => 'target',
                'placeholders' => [
                    'target.name' => [
                        'getters' => [
                            'getTarget',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.cloud.location.Locations' => [
            'GetLocation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListLocations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*}/locations',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deliveryPipelines/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/targets/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deliveryPipelines/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/targets/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deliveryPipelines/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/targets/*}:testIamPermissions',
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
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}:cancel',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
