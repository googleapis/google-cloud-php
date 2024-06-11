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
        'google.shopping.merchant.notifications.v1beta.NotificationsApiService' => [
            'CreateNotificationSubscription' => [
                'method' => 'post',
                'uriTemplate' => '/notifications/v1beta/{parent=accounts/*}/notificationsubscriptions',
                'body' => 'notification_subscription',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'DeleteNotificationSubscription' => [
                'method' => 'delete',
                'uriTemplate' => '/notifications/v1beta/{name=accounts/*/notificationsubscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNotificationSubscription' => [
                'method' => 'get',
                'uriTemplate' => '/notifications/v1beta/{name=accounts/*/notificationsubscriptions/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListNotificationSubscriptions' => [
                'method' => 'get',
                'uriTemplate' => '/notifications/v1beta/{parent=accounts/*}/notificationsubscriptions',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateNotificationSubscription' => [
                'method' => 'patch',
                'uriTemplate' => '/notifications/v1beta/{notification_subscription.name=accounts/*/notificationsubscriptions/*}',
                'body' => 'notification_subscription',
                'placeholders' => [
                    'notification_subscription.name' => [
                        'getters' => [
                            'getNotificationSubscription',
                            'getName',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
