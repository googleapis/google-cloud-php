<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta2.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'method' => 'post',
                'uri' => '/v1beta2/videos:annotate',
                'body' => '*',
            ],
        ],
    ],
];
