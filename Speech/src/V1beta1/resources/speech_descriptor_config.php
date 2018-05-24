<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1beta1.Speech' => [
            'AsyncRecognize' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeResponse',
                    'metadataReturnType' => '\Google\Cloud\Speech\V1beta1\AsyncRecognizeMetadata',
                    'initialPollDelayMillis' => '20000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '86400000',
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
