<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1.Speech' => [
            'Recognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1/speech:recognize',
                'body' => '*',
            ],
            'LongRunningRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1/speech:longrunningrecognize',
                'body' => '*',
            ],
        ],
    ],
];
