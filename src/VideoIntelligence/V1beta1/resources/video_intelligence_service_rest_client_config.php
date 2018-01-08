<?php

return [
    'interfaces' => [
        'google.cloud.videointelligence.v1beta1.VideoIntelligenceService' => [
            'AnnotateVideo' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/videos:annotate',
                'body' => '*',
            ],
        ],
    ],
];
