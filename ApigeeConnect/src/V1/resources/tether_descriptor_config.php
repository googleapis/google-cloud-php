<?php

return [
    'interfaces' => [
        'google.cloud.apigeeconnect.v1.Tether' => [
            'Egress' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
                'callType' => \Google\ApiCore\Call::BIDI_STREAMING_CALL,
                'responseType' => 'Google\Cloud\ApigeeConnect\V1\EgressRequest',
            ],
        ],
    ],
];
