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
        'google.cloud.cloudcontrolspartner.v1beta.CloudControlsPartnerCore' => [
            'CreateCustomer' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/customers',
                'body' => 'customer',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
                'queryParams' => [
                    'customer_id',
                ],
            ],
            'DeleteCustomer' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/customers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCustomer' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/customers/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetEkmConnections' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/customers/*/workloads/*/ekmConnections}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPartner' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/partner}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetPartnerPermissions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/customers/*/workloads/*/partnerPermissions}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetWorkload' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=organizations/*/locations/*/customers/*/workloads/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAccessApprovalRequests' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*/customers/*/workloads/*}/accessApprovalRequests',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListCustomers' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*}/customers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListWorkloads' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{parent=organizations/*/locations/*/customers/*}/workloads',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateCustomer' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{customer.name=organizations/*/locations/*/customers/*}',
                'body' => 'customer',
                'placeholders' => [
                    'customer.name' => [
                        'getters' => [
                            'getCustomer',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
