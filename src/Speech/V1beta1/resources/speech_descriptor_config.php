<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1beta1.Speech' => [
            'AsyncRecognize' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeResponse',
                    'metadataReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeMetadata',
                ],
            ],
            'StreamingRecognize' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
            ],
        ],
    ],
];
