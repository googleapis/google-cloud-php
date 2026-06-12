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
        'google.ads.datamanager.v1.UserListGlobalLicenseService' => [
            'CreateUserListGlobalLicense' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=accountTypes/*/accounts/*}/userListGlobalLicenses',
                'body' => 'user_list_global_license',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'GetUserListGlobalLicense' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=accountTypes/*/accounts/*/userListGlobalLicenses/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListUserListGlobalLicenseCustomerInfos' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accountTypes/*/accounts/*/userListGlobalLicenses/*}/userListGlobalLicenseCustomerInfos',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'ListUserListGlobalLicenses' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=accountTypes/*/accounts/*}/userListGlobalLicenses',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateUserListGlobalLicense' => [
                'method' => 'patch',
                'uriTemplate' => '/v1/{user_list_global_license.name=accountTypes/*/accounts/*/userListGlobalLicenses/*}',
                'body' => 'user_list_global_license',
                'placeholders' => [
                    'user_list_global_license.name' => [
                        'getters' => [
                            'getUserListGlobalLicense',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
