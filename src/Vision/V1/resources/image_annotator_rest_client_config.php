<?php

return [
    'interfaces' => [
        'google.cloud.vision.v1.ImageAnnotator' => [
            'BatchAnnotateImages' => [
                'method' => 'post',
                'uriTemplate' => '/v1/images:annotate',
                'body' => '*',
            ],
        ],
    ],
];
