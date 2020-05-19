<?php

return [
    'interfaces' => [
        'google.cloud.texttospeech.v1.TextToSpeech' => [
            'SynthesizeSpeech' => [
                'method' => 'post',
                'uriTemplate' => '/v1/text:synthesize',
                'body' => '*',
            ],
            'ListVoices' => [
                'method' => 'get',
                'uriTemplate' => '/v1/voices',
            ],
        ],
    ],
];
