<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta2.VideoIntelligenceService' => [
            'annotateVideo' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VideoIntelligence\V1beta2\AnnotateVideoResponse',
                    'metadataReturnType' => '\Google\Cloud\VideoIntelligence\V1beta2\AnnotateVideoProgress',
                ],
            ],
        ],
    ],
];
