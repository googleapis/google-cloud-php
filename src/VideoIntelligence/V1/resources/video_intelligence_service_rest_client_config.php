<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'method' => 'post',
                'uri' => '/v1/videos:annotate',
                'body' => '*',
            ],
        ],
    ],
];
