<?php

return [
    'interfaces' => [
        'google.cloud.advisorynotifications.v1.AdvisoryNotificationsService' => [
            'GetNotification' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{name=organizations/*/locations/*/notifications/*}',
                'placeholders' => [
                    'name' => [
                        'getters' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListNotifications' => [
                'method' => 'get',
                'uriTemplate' => '/v1/{parent=organizations/*/locations/*}/notifications',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
    'numericEnums' => true,
];
