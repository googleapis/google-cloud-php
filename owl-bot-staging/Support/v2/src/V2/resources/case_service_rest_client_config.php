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
        'google.cloud.support.v2.CaseService' => [
            'CloseCase' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/cases/*}:close',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=organizations/*/cases/*}:close',
                        'body' => '*',
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
            'CreateCase' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{parent=projects/*}/cases',
                'body' => 'case',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{parent=organizations/*}/cases',
                        'body' => 'case',
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
            'EscalateCase' => [
                'method' => 'post',
                'uriTemplate' => '/v2/{name=projects/*/cases/*}:escalate',
                'body' => '*',
                'additionalBindings' => [
                    [
                        'method' => 'post',
                        'uriTemplate' => '/v2/{name=organizations/*/cases/*}:escalate',
                        'body' => '*',
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
            'GetCase' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{name=projects/*/cases/*}',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{name=organizations/*/cases/*}',
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
            'ListCases' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/cases',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/cases',
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
            'SearchCaseClassifications' => [
                'method' => 'get',
                'uriTemplate' => '/v2/caseClassifications:search',
            ],
            'SearchCases' => [
                'method' => 'get',
                'uriTemplate' => '/v2/{parent=projects/*}/cases:search',
                'additionalBindings' => [
                    [
                        'method' => 'get',
                        'uriTemplate' => '/v2/{parent=organizations/*}/cases:search',
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
            'UpdateCase' => [
                'method' => 'patch',
                'uriTemplate' => '/v2/{case.name=projects/*/cases/*}',
                'body' => 'case',
                'additionalBindings' => [
                    [
                        'method' => 'patch',
                        'uriTemplate' => '/v2/{case.name=organizations/*/cases/*}',
                        'body' => 'case',
                    ],
                ],
                'placeholders' => [
                    'case.name' => [
                        'getters' => [
                            'getCase',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
