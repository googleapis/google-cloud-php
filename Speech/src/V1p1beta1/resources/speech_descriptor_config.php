<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1p1beta1.Speech' => [
            'LongRunningRecognize' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V1p1beta1\LongRunningRecognizeResponse',
                    'metadataReturnType' => '\Google\Cloud\Speech\V1p1beta1\LongRunningRecognizeMetadata',
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
