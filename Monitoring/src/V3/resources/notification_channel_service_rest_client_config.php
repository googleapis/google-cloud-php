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
        'google.monitoring.v3.NotificationChannelService' => [
            'CreateNotificationChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*}/notificationChannels',
                'body' => 'notification_channel',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'DeleteNotificationChannel' => [
                'method' => 'delete',
                'uriTemplate' => '/v3/{name=projects/*/notificationChannels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNotificationChannel' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/notificationChannels/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNotificationChannelDescriptor' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*/notificationChannelDescriptors/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetNotificationChannelVerificationCode' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/notificationChannels/*}:getVerificationCode',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListNotificationChannelDescriptors' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/notificationChannelDescriptors',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListNotificationChannels' => [
                'method' => 'get',
                'uriTemplate' => '/v3/{name=projects/*}/notificationChannels',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'SendNotificationChannelVerificationCode' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/notificationChannels/*}:sendVerificationCode',
                'body' => '*',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'UpdateNotificationChannel' => [
                'method' => 'patch',
                'uriTemplate' => '/v3/{notification_channel.name=projects/*/notificationChannels/*}',
                'body' => 'notification_channel',
                'placeholders' => [
                    'notification_channel.name' => [
                        'getters' => [
                            'getNotificationChannel',
                            'getName',
                        ],
                    ],
                ],
            ],
            'VerifyNotificationChannel' => [
                'method' => 'post',
                'uriTemplate' => '/v3/{name=projects/*/notificationChannels/*}:verify',
                'body' => '*',
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
