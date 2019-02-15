<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1beta2.WorkflowTemplateService' => [
            'CreateWorkflowTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{parent=projects/*/regions/*}/workflowTemplates',
                'body' => 'template',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/workflowTemplates',
                        'body' => 'template',
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
            'GetWorkflowTemplate' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/workflowTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/workflowTemplates/*}',
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
            'InstantiateWorkflowTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/workflowTemplates/*}:instantiate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/workflowTemplates/*}:instantiate',
                        'body' => '*',
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
            'InstantiateInlineWorkflowTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/workflowTemplates:instantiateInline',
                'body' => 'template',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/regions/*}/workflowTemplates:instantiateInline',
                        'body' => 'template',
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
            'UpdateWorkflowTemplate' => [
                'method' => 'put',
                'uriTemplate' => '/v1beta2/{template.name=projects/*/regions/*/workflowTemplates/*}',
                'body' => 'template',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1beta2/{template.name=projects/*/locations/*/workflowTemplates/*}',
                        'body' => 'template',
                    ],
                ],
                'placeholders' => [
                    'template.name' => [
                        'getters' => [
                            'getTemplate',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListWorkflowTemplates' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta2/{parent=projects/*/regions/*}/workflowTemplates',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1beta2/{parent=projects/*/locations/*}/workflowTemplates',
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
            'DeleteWorkflowTemplate' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta2/{name=projects/*/regions/*/workflowTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1beta2/{name=projects/*/locations/*/workflowTemplates/*}',
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
