<?php

return [
    'interfaces' => [
        'google.cloud.texttospeech.v1.TextToSpeech' => [
            'ListVoices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/voices',
            ],
            'SynthesizeSpeech' => [
                'method' => 'post',
                'uriTemplate' => '/v1/text:synthesize',
                'body' => '*',
            ],
        ],
    ],
];
