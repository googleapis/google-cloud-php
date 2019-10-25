<?php

return [
    'interfaces' => [
        'google.cloud.automl.v1.AutoMl' => [
            'CreateDataset' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/datasets',
                'body' => 'dataset',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateDataset' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{dataset.name=projects/*/locations/*/datasets/*}',
                'body' => 'dataset',
                'placeholders' => [
                    'dataset.name' => [
                        'getters' => [
                            'getDataset',
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDataset' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDatasets' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/datasets',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteDataset' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportData' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*}:importData',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportData' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/datasets/*}:exportData',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreateModel' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/models',
                'body' => 'model',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetModel' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateModel' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{model.name=projects/*/locations/*/models/*}',
                'body' => 'model',
                'placeholders' => [
                    'model.name' => [
                        'getters' => [
                            'getModel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListModels' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/models',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteModel' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetModelEvaluation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/models/*/modelEvaluations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListModelEvaluations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/models/*}/modelEvaluations',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/datasets/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/models/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/datasets/*}:getIamPolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/{resource=projects/*/locations/*/models/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/**}:testIamPermissions',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*}/operations',
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
        ],
    ],
];
