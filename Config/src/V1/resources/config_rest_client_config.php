<?php

return [
    'interfaces' => [
        'google.cloud.config.v1.Config' => [
            'CreateDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deployments',
                'body' => 'deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'deployment_id',
                ],
            ],
            'CreatePreview' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/previews',
                'body' => 'preview',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePreview' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/previews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteStatefile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}:deleteState',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportDeploymentStatefile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deployments/*}:exportState',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ExportLockInfo' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}:exportLock',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExportPreviewResult' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/previews/*}:export',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ExportRevisionStatefile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deployments/*/revisions/*}:exportState',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPreview' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/previews/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetResource' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*/revisions/*/resources/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetRevision' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*/revisions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ImportStatefile' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deployments/*}:importState',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/deployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPreviews' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*}/previews',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListResources' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deployments/*/revisions/*}/resources',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListRevisions' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/deployments/*}/revisions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'LockDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}:lock',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UnlockDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/deployments/*}:unlock',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{deployment.name=projects/*/locations/*/deployments/*}',
                'body' => 'deployment',
                'placeholders' => [
                    'deployment.name' => [
                        'getters' => [
                            'getDeployment',
                            'getName',
                        ],
                    ],
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deployments/*}:getIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deployments/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=projects/*/locations/*/deployments/*}:testIamPermissions',
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
    'numericEnums' => true,
];
