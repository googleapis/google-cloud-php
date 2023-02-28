<?php

return [
    'interfaces' => [
        'google.cloud.gsuiteaddons.v1.GSuiteAddOns' => [
            'CreateDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*}/deployments',
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
            'DeleteDeployment' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/{name=projects/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetAuthorization' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/authorization}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetDeployment' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/deployments/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetInstallStatus' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=projects/*/deployments/*/installStatus}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'InstallDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/deployments/*}:install',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListDeployments' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=projects/*}/deployments',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ReplaceDeployment' => [
                'method' => 'put',
                'uriTemplate' => '/v1/{deployment.name=projects/*/deployments/*}',
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
            'UninstallDeployment' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{name=projects/*/deployments/*}:uninstall',
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
