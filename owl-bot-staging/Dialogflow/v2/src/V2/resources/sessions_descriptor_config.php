<?php

return [
    'interfaces' => [
        'google.cloud.dialogflow.v2.Sessions' => [
            'StreamingDetectIntent' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
            ],
        ],
    ],
];
