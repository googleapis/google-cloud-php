<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta1.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\VideoIntelligence\V1beta1\AnnotateVideoResponse',
                    'metadataReturnType' => '\Google\Cloud\VideoIntelligence\V1beta1\AnnotateVideoProgress',
                ],
            ],
        ],
    ],
];
