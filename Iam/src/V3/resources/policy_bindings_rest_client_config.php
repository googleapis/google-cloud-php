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
        'google.iam.v3.PolicyBindings' => [
            'CreatePolicyBinding' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/policyBindings',
                'body' => 'policy_binding',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=folders/*/locations/*}/policyBindings',
                        'body' => 'policy_binding',
                        'queryParams' => [
                            'policy_binding_id',
                        ],
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v3/{parent=organizations/*/locations/*}/policyBindings',
                        'body' => 'policy_binding',
                        'queryParams' => [
                            'policy_binding_id',
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
                    'policy_binding_id',
                ],
            ],
            'DeletePolicyBinding' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/policyBindings/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v3/{name=folders/*/locations/*/policyBindings/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v3/{name=organizations/*/locations/*/policyBindings/*}',
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
            'GetPolicyBinding' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/locations/*/policyBindings/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=folders/*/locations/*/policyBindings/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{name=organizations/*/locations/*/policyBindings/*}',
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
            'ListPolicyBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/policyBindings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=folders/*/locations/*}/policyBindings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=organizations/*/locations/*}/policyBindings',
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
            'SearchTargetPolicyBindings' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{parent=projects/*/locations/*}/policyBindings:searchTargetPolicyBindings',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=folders/*/locations/*}/policyBindings:searchTargetPolicyBindings',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v3/{parent=organizations/*/locations/*}/policyBindings:searchTargetPolicyBindings',
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
            'UpdatePolicyBinding' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{policy_binding.name=projects/*/locations/*/policyBindings/*}',
                'body' => 'policy_binding',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v3/{policy_binding.name=folders/*/locations/*/policyBindings/*}',
                        'body' => 'policy_binding',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v3/{policy_binding.name=organizations/*/locations/*/policyBindings/*}',
                        'body' => 'policy_binding',
                    ],
                ],
                'placeholders' => [
                    'policy_binding.name' => [
                        'getters' => [
                            'getPolicyBinding',
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
