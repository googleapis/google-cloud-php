<?php

return [
    'interfaces' => [
        'google.cloud.dataproc.v1.WorkflowTemplateService' => [
            'CreateWorkflowTemplate' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/workflowTemplates',
                'body' => 'template',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/regions/*}/workflowTemplates',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/workflowTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{name=projects/*/regions/*/workflowTemplates/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/workflowTemplates/*}:instantiate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{name=projects/*/regions/*/workflowTemplates/*}:instantiate',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/workflowTemplates:instantiateInline',
                'body' => 'template',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{parent=projects/*/regions/*}/workflowTemplates:instantiateInline',
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
                'uriTemplate' => '/v1/{template.name=projects/*/locations/*/workflowTemplates/*}',
                'body' => 'template',
                'additionalBindings' => [
                    [
                        'method' => 'put',
                        'uriTemplate' => '/v1/{template.name=projects/*/regions/*/workflowTemplates/*}',
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
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/workflowTemplates',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{parent=projects/*/regions/*}/workflowTemplates',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/workflowTemplates/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v1/{name=projects/*/regions/*/workflowTemplates/*}',
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
        'google.longrunning.Operations' => [
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations}',
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
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations/*}',
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
                'uriTemplate' => '/v1/{name=projects/*/regions/*/operations/*}:cancel',
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
