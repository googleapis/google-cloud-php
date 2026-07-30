<?php
/*
 * Copyright 2026 Google LLC
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
        'google.iam.v3.AccessPolicies' => [
            'CreateAccessPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/accessPolicies',
                'body' => 'access_policy',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=folders/*/locations/*}/accessPolicies',
                        'body' => 'access_policy',
                        'queryParams' => [
                            'access_policy_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=organizations/*/locations/*}/accessPolicies',
                        'body' => 'access_policy',
                        'queryParams' => [
                            'access_policy_id',
                        ],
                    ],
                ],
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'access_policy_id',
                ],
            ],
            'DeleteAccessPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/accessPolicies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v3/{name=folders/*/locations/*/accessPolicies/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v3/{name=organizations/*/locations/*/accessPolicies/*}',
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
            'GetAccessPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/accessPolicies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=folders/*/locations/*/accessPolicies/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=organizations/*/locations/*/accessPolicies/*}',
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
            'ListAccessPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/accessPolicies',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=folders/*/locations/*}/accessPolicies',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=organizations/*/locations/*}/accessPolicies',
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
            'SearchAccessPolicyBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=organizations/*/locations/*/accessPolicies/*}:searchPolicyBindings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=folders/*/locations/*/accessPolicies/*}:searchPolicyBindings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=projects/*/locations/*/accessPolicies/*}:searchPolicyBindings',
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
            'UpdateAccessPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{access_policy.name=projects/*/locations/*/accessPolicies/*}',
                'body' => 'access_policy',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v3/{access_policy.name=folders/*/locations/*/accessPolicies/*}',
                        'body' => 'access_policy',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v3/{access_policy.name=organizations/*/locations/*/accessPolicies/*}',
                        'body' => 'access_policy',
                    ],
                ],
                'placeholders' => [
                    'access_policy.name' => [
                        'getters' => [
                            'getAccessPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/operations/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=folders/*/locations/*/operations/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=organizations/*/locations/*/operations/*}',
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
    ],
    'numericEnums' => true,
];
