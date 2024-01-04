<?php

return [
    'interfaces' => [
        'google.cloud.advisorynotifications.v1.AdvisoryNotificationsService' => [
            'GetNotification' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AdvisoryNotifications\V1\Notification',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'GetSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AdvisoryNotifications\V1\Settings',
                'headerParams' => [
                    [
                        'keyName' => 'name',
                        'fieldAccessors' => [
                            'getName',
                        ],
                    ],
                ],
            ],
            'ListNotifications' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getNotifications',
                ],
                'callType' => \Google\ApiCore\Call::PAGINATED_CALL,
                'responseType' => 'Google\Cloud\AdvisoryNotifications\V1\ListNotificationsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'parent',
                        'fieldAccessors' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
            'UpdateSettings' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\AdvisoryNotifications\V1\Settings',
                'headerParams' => [
                    [
                        'keyName' => 'settings.name',
                        'fieldAccessors' => [
                            'getSettings',
                            'getName',
                        ],
                    ],
                ],
            ],
            'templateMap' => [
                'location' => 'organizations/{organization}/locations/{location}',
                'notification' => 'organizations/{organization}/locations/{location}/notifications/{notification}',
                'organizationLocation' => 'organizations/{organization}/locations/{location}',
                'organizationLocationNotification' => 'organizations/{organization}/locations/{location}/notifications/{notification}',
                'projectLocation' => 'projects/{project}/locations/{location}',
                'projectLocationNotification' => 'projects/{project}/locations/{location}/notifications/{notification}',
                'settings' => 'organizations/{organization}/locations/{location}/settings',
            ],
        ],
    ],
];
