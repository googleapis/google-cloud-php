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
        'google.cloud.orgpolicy.v2.OrgPolicy' => [
            'CreateCustomConstraint' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=organizations/*}/customConstraints',
                'body' => 'custom_constraint',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'CreatePolicy' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/policies',
                'body' => 'policy',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=folders/*}/policies',
                        'body' => 'policy',
                    ],
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*}/policies',
                        'body' => 'policy',
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
            'DeleteCustomConstraint' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=organizations/*/customConstraints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeletePolicy' => [
                'method' => 'delete',
                'uriTemplate' => '/v2/{name=projects/*/policies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=folders/*/policies/*}',
                    ],
                    [
                        'method' => 'delete',
                        'uriTemplate' => '/v2/{name=organizations/*/policies/*}',
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
            'GetCustomConstraint' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=organizations/*/customConstraints/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEffectivePolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/policies/*}:getEffectivePolicy',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/policies/*}:getEffectivePolicy',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/policies/*}:getEffectivePolicy',
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
            'GetPolicy' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/policies/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=folders/*/policies/*}',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/policies/*}',
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
            'ListConstraints' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/constraints',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*}/constraints',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/constraints',
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
            'ListCustomConstraints' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=organizations/*}/customConstraints',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListPolicies' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/policies',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=folders/*}/policies',
                    ],
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/policies',
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
            'UpdateCustomConstraint' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{custom_constraint.name=organizations/*/customConstraints/*}',
                'body' => 'custom_constraint',
                'placeholders' => [
                    'custom_constraint.name' => [
                        'getters' => [
                            'getCustomConstraint',
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdatePolicy' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{policy.name=projects/*/policies/*}',
                'body' => 'policy',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{policy.name=folders/*/policies/*}',
                        'body' => 'policy',
                    ],
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{policy.name=organizations/*/policies/*}',
                        'body' => 'policy',
                    ],
                ],
                'placeholders' => [
                    'policy.name' => [
                        'getters' => [
                            'getPolicy',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
