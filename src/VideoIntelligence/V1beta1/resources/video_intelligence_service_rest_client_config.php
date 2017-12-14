<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta1.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'method' => 'post',
                'uri' => '/v1beta1/videos:annotate',
                'body' => '*',
            ],
        ],
    ],
];
