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
        'google.cloud.support.v2beta.SupportEventSubscriptionService' => [
            'CreateSupportEventSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/{parent=*/*}/supportEventSubscriptions',
                'body' => 'support_event_subscription',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteSupportEventSubscription' => [
                'method' => 'delete',
                'uriTemplate' => '/v2beta/{name=*/*/supportEventSubscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSupportEventSubscription' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{name=*/*/supportEventSubscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSupportEventSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/v2beta/{parent=*/*}/supportEventSubscriptions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UndeleteSupportEventSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v2beta/{name=*/*/supportEventSubscriptions/*}:undelete',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSupportEventSubscription' => [
                'method' => 'patch',
                'uriTemplate' => '/v2beta/{support_event_subscription.name=*/*/supportEventSubscriptions/*}',
                'body' => 'support_event_subscription',
                'placeholders' => [
                    'support_event_subscription.name' => [
                        'getters' => [
                            'getSupportEventSubscription',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
