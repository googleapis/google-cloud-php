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
        'google.apps.events.subscriptions.v1beta.SubscriptionsService' => [
            'CreateSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/subscriptions',
                'body' => 'subscription',
            ],
            'DeleteSubscription' => [
                'method' => 'delete',
                'uriTemplate' => '/v1beta/{name=subscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSubscription' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=subscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/subscriptions',
                'queryParams' => [
                    'filter',
                ],
            ],
            'ReactivateSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta/{name=subscriptions/*}:reactivate',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateSubscription' => [
                'method' => 'patch',
                'uriTemplate' => '/v1beta/{subscription.name=subscriptions/*}',
                'body' => 'subscription',
                'placeholders' => [
                    'subscription.name' => [
                        'getters' => [
                            'getSubscription',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
        'google.longrunning.Operations' => [
            'GetOperation' => [
                'method' => 'get',
                'uriTemplate' => '/v1beta/{name=operations/**}',
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
