<?php

return [
    'interfaces' => [
        'google.pubsub.v1.Subscriber' => [
            'ListSubscriptions' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSubscriptions',
                ],
            ],
            'ListSnapshots' => [
                'pageStreaming' => [
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getSnapshots',
                ],
            ],
            'StreamingPull' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                    'resourcesGetMethod' => 'getReceivedMessages',
                ],
            ],
        ],
    ],
];
