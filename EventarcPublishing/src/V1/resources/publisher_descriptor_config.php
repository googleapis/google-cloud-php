<?php

return [
    'interfaces' => [
        'google.cloud.eventarc.publishing.v1.Publisher' => [
            'PublishChannelConnectionEvents' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Eventarc\Publishing\V1\PublishChannelConnectionEventsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'channel_connection',
                        'fieldAccessors' => [
                            'getChannelConnection',
                        ],
                    ],
                ],
            ],
            'PublishEvents' => [
                'callType' => \Google\ApiCore\Call::UNARY_CALL,
                'responseType' => 'Google\Cloud\Eventarc\Publishing\V1\PublishEventsResponse',
                'headerParams' => [
                    [
                        'keyName' => 'channel',
                        'fieldAccessors' => [
                            'getChannel',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
