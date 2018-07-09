<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1.Speech' => [
            'LongRunningRecognize' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\Speech\V1\LongRunningRecognizeResponse',
                    'metadataReturnType' => '\Google\Cloud\Speech\V1\LongRunningRecognizeMetadata',
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
