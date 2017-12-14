<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1.VideoIntelligenceService' => [
            'annotateVideo' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VideoIntelligence\V1\AnnotateVideoResponse',
                    'metadataReturnType' => '\Google\Cloud\VideoIntelligence\V1\AnnotateVideoProgress',
                ],
            ],
        ],
    ],
];
