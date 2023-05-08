<?php

return [
    'interfaces' => [
        'google.cloud.texttospeech.v1.TextToSpeechLongAudioSynthesize' => [
            'SynthesizeLongAudio' => [
                'longRunning' => [
                    'operationReturnType' => '\Google\Cloud\TextToSpeech\V1\SynthesizeLongAudioResponse',
                    'metadataReturnType' => '\Google\Cloud\TextToSpeech\V1\SynthesizeLongAudioMetadata',
                    'initialPollDelayMillis' => '500',
                    'pollDelayMultiplier' => '1.5',
                    'maxPollDelayMillis' => '5000',
                    'totalPollTimeoutMillis' => '300000',
                ],
            ],
        ],
    ],
];
