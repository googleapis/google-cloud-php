<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1beta2.AutoscalingPolicyService' => [
            'CreateAutoscalingPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/autoscalingPolicies',
                'body' => 'policy',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/regions/*}/autoscalingPolicies',
                        'body' => 'policy',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAutoscalingPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/autoscalingPolicies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/autoscalingPolicies/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAutoscalingPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/autoscalingPolicies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/autoscalingPolicies/*}',
                    ],
                ],
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAutoscalingPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/autoscalingPolicies',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/regions/*}/autoscalingPolicies',
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateAutoscalingPolicy' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta2/{policy.name=projects/*/locations/*/autoscalingPolicies/*}',
                'body' => 'policy',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1beta2/{policy.name=projects/*/regions/*/autoscalingPolicies/*}',
                        'body' => 'policy',
                    ],
                ],
                'placeholders' => [
                    'policy.name' => [
                        'getters' => [
                            'getPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{resource=projects/*/regions/*/clusters/*}:setIamPolicy',
                'body' => '*',
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
                'uriTemplate' => '/v1beta2/{resource=projects/*/regions/*/clusters/*}:getIamPolicy',
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
                'uriTemplate' => '/v1beta2/{resource=projects/*/regions/*/clusters/*}:testIamPermissions',
                'body' => '*',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/operations}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/operations/*}',
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
                'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/operations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/operations/*}:cancel',
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
