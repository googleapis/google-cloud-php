<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1beta1.Speech' => [
            'asyncRecognize' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeResponse',
                    'metadataReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeMetadata',
                ],
            ],
            'streamingRecognize' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
            ],
        ],
    ],
];
