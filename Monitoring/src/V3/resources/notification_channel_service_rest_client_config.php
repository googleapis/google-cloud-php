<?php

return [
    'interfaces' => [
        'google.monitoring.v3.NotificationChannelService' => [
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
        ],
    ],
];
