<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta2.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VideoIntelligence\V1beta2\AnnotateVideoResponse',
                    'metadataReturnType' => '\Google\Cloud\VideoIntelligence\V1beta2\AnnotateVideoProgress',
                ],
            ],
        ],
    ],
];
