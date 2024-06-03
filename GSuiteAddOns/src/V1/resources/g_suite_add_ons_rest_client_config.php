<?php
/*
 * Copyright 2024 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was automatically generated - do not edit!
 */

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
    'numericEnums' => true,
];
