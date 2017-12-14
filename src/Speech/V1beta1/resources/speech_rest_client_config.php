<?php

return [
    'interfaces' => [
        'google.cloud.speech.v1beta1.Speech' => [
            'SyncRecognize' => [
                'method' => 'post',
                'uri' => '/v1beta1/speech:syncrecognize',
                'body' => '*',
            ],
            'AsyncRecognize' => [
                'method' => 'post',
                'uri' => '/v1beta1/speech:asyncrecognize',
                'body' => '*',
            ],
        ],
    ],
];
