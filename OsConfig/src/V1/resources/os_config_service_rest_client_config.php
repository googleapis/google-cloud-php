<?php

return [
    'interfaces' => [
        'google.cloud.osconfig.v1.OsConfigService' => [
            'CancelPatchJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/patchJobs/*}:cancel',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'CreatePatchDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/patchDeployments',
                'body' => 'patch_deployment',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'patch_deployment_id',
                ],
            ],
            'DeletePatchDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/patchDeployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ExecutePatchJob' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/patchJobs:execute',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetPatchDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/patchDeployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPatchJob' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/patchJobs/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPatchDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/patchDeployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPatchJobInstanceDetails' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*/patchJobs/*}/instanceDetails',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPatchJobs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/patchJobs',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'PausePatchDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/patchDeployments/*}:pause',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ResumePatchDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/patchDeployments/*}:resume',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePatchDeployment' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{patch_deployment.name=projects/*/patchDeployments/*}',
                'body' => 'patch_deployment',
                'placeholders' => [
                    'patch_deployment.name' => [
                        'getters' => [
                            'getPatchDeployment',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'CancelOperation' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/locations/*/osPolicyAssignments/*/operations/*}:cancel',
                'body' => '*',
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
                'uriTemplate' => '/v1/{name=projects/*/locations/*/osPolicyAssignments/*/operations/*}',
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
