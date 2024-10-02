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
        'google.marketingplatform.admin.v1alpha.MarketingplatformAdminService' => [
            'CreateAnalyticsAccountLink' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/analyticsAccountLinks',
                'body' => 'analytics_account_link',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteAnalyticsAccountLink' => [
                'method' => 'delete',
                'uriTemplate' => '/v1alpha/{name=organizations/*/analyticsAccountLinks/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetOrganization' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{name=organizations/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListAnalyticsAccountLinks' => [
                'method' => 'get',
                'uriTemplate' => '/v1alpha/{parent=organizations/*}/analyticsAccountLinks',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'SetPropertyServiceLevel' => [
                'method' => 'post',
                'uriTemplate' => '/v1alpha/{analytics_account_link=organizations/*/analyticsAccountLinks/*}:setPropertyServiceLevel',
                'body' => '*',
                'placeholders' => [
                    'analytics_account_link' => [
                        'getters' => [
                            'getAnalyticsAccountLink',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
