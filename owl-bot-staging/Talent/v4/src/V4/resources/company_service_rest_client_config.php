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
        'google.cloud.talent.v4.CompanyService' => [
            'CreateCompany' => [
                'method' => 'post',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/companies',
                'body' => 'company',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCompany' => [
                'method' => 'delete',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*/companies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCompany' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/tenants/*/companies/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListCompanies' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{parent=projects/*/tenants/*}/companies',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCompany' => [
                'method' => 'patch',
                'uriTemplate' => '/v4/{company.name=projects/*/tenants/*/companies/*}',
                'body' => 'company',
                'placeholders' => [
                    'company.name' => [
                        'getters' => [
                            'getCompany',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v4/{name=projects/*/operations/*}',
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
