<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta2.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta2/videos:annotate',
                'body' => '*',
            ],
        ],
    ],
];
