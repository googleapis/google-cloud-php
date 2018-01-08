<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1beta1.Speech' => [
            'SyncRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/speech:syncrecognize',
                'body' => '*',
            ],
            'AsyncRecognize' => [
                'method' => 'post',
                'uriTemplate' => '/v1beta1/speech:asyncrecognize',
                'body' => '*',
            ],
        ],
    ],
];
