<?php

return [
    'interfaces' => [
        'google.cloud.texttospeech.v1.TextToSpeechLongAudioSynthesize' => [
            'SynthesizeLongAudio' => [
                'method' => 'post',
                'uriTemplate' => '/v1/{parent=projects/*/locations/*/voices/*}:SynthesizeLongAudio',
                'body' => '*',
                'placeholders' => [
                    'parent' => [
                        'getters' => [
                            'getParent',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
