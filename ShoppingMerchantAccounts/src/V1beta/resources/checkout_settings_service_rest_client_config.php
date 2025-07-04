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
        'google.shopping.merchant.accounts.v1beta.CheckoutSettingsService' => [
            'CreateCheckoutSettings' => [
                'method' => 'post',
                'uriTemplate' => '/accounts/v1beta/{parent=accounts/*/programs/*}/checkoutSettings',
                'body' => 'checkout_settings',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteCheckoutSettings' => [
                'method' => 'delete',
                'uriTemplate' => '/accounts/v1beta/{name=accounts/*/programs/*/checkoutSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetCheckoutSettings' => [
                'method' => 'get',
                'uriTemplate' => '/accounts/v1beta/{name=accounts/*/programs/*/checkoutSettings}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateCheckoutSettings' => [
                'method' => 'patch',
                'uriTemplate' => '/accounts/v1beta/{checkout_settings.name=accounts/*/programs/*/checkoutSettings}',
                'body' => 'checkout_settings',
                'placeholders' => [
                    'checkout_settings.name' => [
                        'getters' => [
                            'getCheckoutSettings',
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
