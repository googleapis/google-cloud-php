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
        'google.api.servicemanagement.v1.ServiceManager' => [
            'CreateService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services',
                'body' => 'service',
            ],
            'CreateServiceConfig' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services/{service_name}/configs',
                'body' => 'service_config',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'CreateServiceRollout' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services/{service_name}/rollouts',
                'body' => 'rollout',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'DeleteService' => [
                'method' => 'delete',
                'uriTemplate' => '/v1/services/{service_name}',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'GenerateConfigReport' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services:generateConfigReport',
                'body' => '*',
            ],
            'GetService' => [
                'method' => 'get',
                'uriTemplate' => '/v1/services/{service_name}',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'GetServiceConfig' => [
                'method' => 'get',
                'uriTemplate' => '/v1/services/{service_name}/configs/{config_id}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v1/services/{service_name}/config',
                    ],
                ],
                'placeholders' => [
                    'config_id' => [
                        'getters' => [
                            'getConfigId',
                        ],
                    ],
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'GetServiceRollout' => [
                'method' => 'get',
                'uriTemplate' => '/v1/services/{service_name}/rollouts/{rollout_id}',
                'placeholders' => [
                    'rollout_id' => [
                        'getters' => [
                            'getRolloutId',
                        ],
                    ],
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'ListServiceConfigs' => [
                'method' => 'get',
                'uriTemplate' => '/v1/services/{service_name}/configs',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'ListServiceRollouts' => [
                'method' => 'get',
                'uriTemplate' => '/v1/services/{service_name}/rollouts',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'filter',
                ],
            ],
            'ListServices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/services',
            ],
            'SubmitConfigSource' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services/{service_name}/configs:submit',
                'body' => '*',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
            'UndeleteService' => [
                'method' => 'post',
                'uriTemplate' => '/v1/services/{service_name}:undelete',
                'placeholders' => [
                    'service_name' => [
                        'getters' => [
                            'getServiceName',
                        ],
                    ],
                ],
            ],
        ],
        'google.iam.v1.IAMPolicy' => [
            'GetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=services/*}:getIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=services/*/consumers/*}:getIamPolicy',
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
            'SetIamPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{resource=services/*}:setIamPolicy',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=services/*/consumers/*}:setIamPolicy',
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
                'uriTemplate' => '/v1/{resource=services/*}:testIamPermissions',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v1/{resource=services/*/consumers/*}:testIamPermissions',
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
            'ListOperations' => [
                'method' => 'get',
                'uriTemplate' => '/v1/operations',
            ],
        ],
    ],
    'numericEnums' => true,
];
