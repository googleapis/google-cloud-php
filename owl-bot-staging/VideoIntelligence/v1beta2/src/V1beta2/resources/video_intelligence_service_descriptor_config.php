<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta2.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VideoIntelligence\V1beta2\AnnotateVideoResponse',
                    'metadataReturnType' => '\Google\Cloud\VideoIntelligence\V1beta2\AnnotateVideoProgress',
                    'initialPollDelayMillis' => '20000',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '45000',
                    'totalPollTimeoutMillis' => '86400000',
                ],
            ],
        ],
    ],
];
