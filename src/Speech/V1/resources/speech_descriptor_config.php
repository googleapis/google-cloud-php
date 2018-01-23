<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1.Speech' => [
            'LongRunningRecognize' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V1\LongRunningRecognizeResponse',
                    'metadataReturnType' => '\Google\Cloud\Speech\V1\LongRunningRecognizeMetadata',
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
