<?php

return [
    'interfaces' => [
        'google.cloud.eventarc.publishing.v1.Publisher' => [
            'PublishChannelConnectionEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{channel_connection=projects/*/locations/*/channelConnections/*}:publishEvents',
                'body' => '*',
                'placeholders' => [
                    'channel_connection' => [
                        'getters' => [
                            'getChannelConnection',
                        ],
                    ],
                ],
            ],
            'PublishEvents' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{channel=projects/*/locations/*/channels/*}:publishEvents',
                'body' => '*',
                'placeholders' => [
                    'channel' => [
                        'getters' => [
                            'getChannel',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
