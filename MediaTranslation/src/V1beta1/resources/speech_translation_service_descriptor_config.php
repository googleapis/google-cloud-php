<?php

return [
    'interfaces' => [
        'google.cloud.mediatranslation.v1beta1.SpeechTranslationService' => [
            'StreamingTranslateSpeech' => [
                'grpcStreaming' => [
                    'grpcStreamingType' => 'BidiStreaming',
                ],
            ],
        ],
    ],
];
