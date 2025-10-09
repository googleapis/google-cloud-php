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
        'google.cloud.commerce.consumer.procurement.v1.LicenseManagementService' => [
            'Assign' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=billingAccounts/*/orders/*/licensePool}:assign',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'EnumerateLicensedUsers' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=billingAccounts/*/orders/*/licensePool}:enumerateLicensedUsers',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetLicensePool' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=billingAccounts/*/orders/*/licensePool}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'Unassign' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=billingAccounts/*/orders/*/licensePool}:unassign',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateLicensePool' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{license_pool.name=billingAccounts/*/orders/*/licensePool}',
                'body' => 'license_pool',
                'placeholders' => [
                    'license_pool.name' => [
                        'getters' => [
                            'getLicensePool',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=billingAccounts/*/orders/*/operations/*}',
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
