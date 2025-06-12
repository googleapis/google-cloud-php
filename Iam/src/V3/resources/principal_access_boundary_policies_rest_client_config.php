<?php
/*
 * Copyright 2025 Google LLC
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
        'google.iam.v3.PrincipalAccessBoundaryPolicies' => [
            'CreatePrincipalAccessBoundaryPolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=organizations/*/locations/*}/principalAccessBoundaryPolicies',
                'body' => 'principal_access_boundary_policy',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'principal_access_boundary_policy_id',
                ],
            ],
            'DeletePrincipalAccessBoundaryPolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=organizations/*/locations/*/principalAccessBoundaryPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPrincipalAccessBoundaryPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=organizations/*/locations/*/principalAccessBoundaryPolicies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListPrincipalAccessBoundaryPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=organizations/*/locations/*}/principalAccessBoundaryPolicies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SearchPrincipalAccessBoundaryPolicyBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=organizations/*/locations/*/principalAccessBoundaryPolicies/*}:searchPolicyBindings',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePrincipalAccessBoundaryPolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{principal_access_boundary_policy.name=organizations/*/locations/*/principalAccessBoundaryPolicies/*}',
                'body' => 'principal_access_boundary_policy',
                'placeholders' => [
                    'principal_access_boundary_policy.name' => [
                        'getters' => [
                            'getPrincipalAccessBoundaryPolicy',
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
