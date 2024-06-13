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
        'google.shopping.merchant.accounts.v1beta.HomepageService' => [
            'ClaimHomepage' => [
                'method' => 'post',
                'uriTemplate' => '/accounts/v1beta/{name=accounts/*/homepage}:claim',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetHomepage' => [
                'method' => 'get',
                'uriTemplate' => '/accounts/v1beta/{name=accounts/*/homepage}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UnclaimHomepage' => [
                'method' => 'post',
                'uriTemplate' => '/accounts/v1beta/{name=accounts/*/homepage}:unclaim',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateHomepage' => [
                'method' => 'patch',
                'uriTemplate' => '/accounts/v1beta/{homepage.name=accounts/*/homepage}',
                'body' => 'homepage',
                'placeholders' => [
                    'homepage.name' => [
                        'getters' => [
                            'getHomepage',
                            'getName',
                        ],
                    ],
                ],
                'queryParams' => [
                    'update_mask',
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
